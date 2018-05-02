<?php

error_reporting(E_ERROR | E_PARSE);

require_once ('../functions/constants.php');
require_once ('../third-party/phpmailer/class.phpmailer.php');
require_once ('../third-party/phpmailer/class.smtp.php');
require_once ('../third-party/aws/aws-autoloader.php') ;
require_once ('../assets/vendor/autoload.php');

require_once ('ServiceInit.php');

$settingDao = get_new_SettingDao();
$settings = $settingDao->loadSetting();
if ($settings->lang == "en")
{
  include '../lang/lang_en.php';
}
else {
  include '../lang/lang_hu.php';
}

function get_new_campaignDao()
{
    return new CampaignDao(db_host, db_name, db_username, db_password);
}

function get_new_MappingDao()
{
    return new MappingDao(db_host, db_name, db_username, db_password);
}

function get_new_SettingDao()
{
    return new SettingDao(db_host, db_name, db_username, db_password);
}

function get_new_EmailListDao(){
    return new EmailListDao(db_host, db_name, db_username, db_password);
}

function Main()
{
    sleep(2);
    $last_campaign_id = -1;

    $get_time = file_get_contents("/tmp/checkfile.lock");
    $del_time = time()-$get_time;
    if ( $del_time < 2 ){
        echo "The service is running.\n";
        return ;
    }

    while(1)
    {
        $campaignDao = get_new_campaignDao();
        $id = $campaignDao->getNextCampaignId($last_campaign_id);
        if ( $id >= 0 )
        {
            $pid = pcntl_fork();
            if ( $pid == -1 )
            {
                exit("error forking...\n");
            }else if ( $pid == 0)
            {
                $camp_pro = new CampaignProcess($id);
                $camp_pro->start();
                exit();
            }
            $last_campaign_id = $id;
        }
        sleep(1);
        file_put_contents("/tmp/checkfile.lock", time());
    }
    while(pcntl_waitpid(0, $status) != -1);
}

class subscriber
{
    public $id;
    public $email;
    public $status;
    public $f_name;
    public $l_name;
    public $listID;
    public function __construct($id, $f_name, $l_name, $status, $email, $listID)
    {
        $this->id = $id;
        $this->email = $email;
        $this->status = $status;
        $this->f_name = $f_name;
        $this->l_name = $l_name;
        $this->listID = $listID;
    }
}

class CampaignProcess
{
    private $id;
    private $last_sub_id;
    private $delivery_delay;
    private $subList;
    private $conn_type;
    private $template;
    private $map;


    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getTemplate($index)
    {
        $dao = get_new_campaignDao();
        $camp = $dao->getCampaign($this->id);
        $sub = $this->subList[$index];

        $mappingDao= get_new_MappingDao();
        $map        = new MappingModel();
        $map->campaign_id   = $this->id;
        $map->subscriber_id = $sub->id;
        $map->status = 0;

        $settingDao = get_new_SettingDao();
        $setting = $settingDao->loadSetting();
        if ( $setting->limit_day_period != null ) {
            while ($mappingDao->getCountOfEmails($setting->limit_day_period) >= $setting->max_mail_counts) {
                echo ".";
                sleep(10);
                $mappingDao->getCountOfEmails($setting->limit_day_period);
                $setting = $settingDao->loadSetting();
            }
        }

        $mappingDao->createMapping($map);
        $mapping_id = $mappingDao->getLastInsertId();

        $body = $camp->email_content;

        $body = str_replace("{sub_id}", $sub->id, $body);
        $body = str_replace("{cam_id}", $camp->id, $body);

        $body         = str_replace("{f_name}", $sub->f_name, $body);
        $body         = str_replace("{l_name}", $sub->l_name, $body);
        $body         = str_replace("{email_subject}", $camp->subject, $body);
        $body         = str_replace("{address}", $setting->company_address, $body);
        $body         = str_replace("{form_unsubscribe.php}", 'form_unsubscribe.php?email='.$sub->email.'&list='.$sub->listID, $body);
        $body         = str_replace("{email_view.php}", 'email_view.php?campaign='.$camp->id.'&&sub='.$sub->id, $body);
        $body         = str_replace("{view_in_your_browser}", "View in your browser", $body);
        $body         = str_replace("{company}", $setting->company_name, $body);
        $body         = str_replace("{Unsubscribe}", "Unsubscribe", $body);
        $body         = str_replace("{mapping_id}", $mapping_id, $body);

        $style = file_get_contents("../styles/email.css");
        $emogrifier = new \Pelago\Emogrifier($body, $style);
        $body = $emogrifier->emogrifyBodyContent();
        $responsive_style = file_get_contents("../styles/responsive.css");
        $this->template =
            '<html>
                <head>
                  <meta http-equiv="X-UA-Compatible" content="IE=edge">
          	      <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
                  <style>'
                  .$responsive_style.
                 '</style>
                </head>
                <body>'
                    .$body.
                '</body>
                <img src="'.HOME_URL.'/service/request.php?'.
                'sub_id='.$sub->id.'&cam_id='.$camp->id.'&state='.SUB_STATE_OPEN.'&mapping_id='.$mapping_id.
                '" style="width: 1px;height: 1px;">
            </html>';
        return $mapping_id;
    }

    public function init()
    {
        $dao = get_new_campaignDao();

        //========init========
        $camp = $dao->getCampaign($this->id);
        if ( $camp->status == CAMPAIGN_IN_COMPLETED ){
            return -1;
        }
        $camp->status = CAMPAIGN_SCHEDULED;
        $dao->updateCampaign($camp);
        echo "scheduled\n";

        $this->delivery_delay = $camp->delivery_delay_sec;
        $this->last_sub_id = -1;
        $conn = $dao->getConnection($camp->connection_id);
        $this->conn_type = strtolower($conn->type);
        $this->subList = [];

        $settingDao = get_new_SettingDao();
        $setting = $settingDao->loadSetting();
        if ($setting->time_zone){
        	date_default_timezone_set($setting->time_zone);
        }

        $start = strtotime($camp->delivery_datetime);

        if ( time() < $start ){
            echo "wait start time...\n";
            while(time() < $start){
                sleep(1);
                $camp = $dao->getCampaign($this->id);
                $start = strtotime($camp->delivery_datetime);
            }
        }
        else {
            echo "start...\n";
        }

        //==========update===========
        $camp->status = CAMPAIGN_IN_PROGRESS;
        $dao->updateCampaign($camp);
        echo "in progress\n";
        return 1;
    }

    public function database_process()
    {
        $dao = get_new_campaignDao();
        $camp = $dao->getCampaign($this->id);
        if ( $camp ) {
            $conn = $dao->getConnection($camp->connection_id);
            //------------> connection diabled!<----------------
            if (!$conn->enabled) {
                $camp->status = CAMPAIGN_STOPPED;
                $dao->updateCampaign($camp);

                echo "$this->id: disabled\n";
                while (!$conn->enabled) {
                    sleep(1);
                    $conn = $dao->getConnection($camp->connection_id);
                }
                $camp->status = CAMPAIGN_IN_PROGRESS;
                $dao->updateCampaign($camp);
                echo "$this->id: enabled\n";
            }
        }else{
            echo "$this->id: deleted\n";
            return false;
        }
        return true;
    }

    public function update_sub_list()
    {
        $dao = get_new_campaignDao();
        $subs = $dao->getAllEmailsOfCampaign($this->id, $this->last_sub_id);

        $added = count($subs);

        for ( $i = 0; $i < $added; $i ++){
            $sub = new subscriber(
                $subs[$i]->id,
                $subs[$i]->first_name,
                $subs[$i]->last_name,
                $subs[$i]->status,
                $subs[$i]->email,
                $subs[$i]->email_list_id
            );
            $this->subList[] = $sub;

            if ( $this->last_sub_id < $sub->id) {
                $this->last_sub_id = $sub->id;
            }
        }
        return $added;
    }

    public function get_next_subscriber($index)
    {
        if (!$this->database_process()) {
            return -1;
        }
        $sub_cnt = count($this->subList);
        $sub_cnt += $this->update_sub_list();
        $index ++;
        while ($index < $sub_cnt && $this->map[$this->subList[$index]->email] == 1){
            $index ++;
        }
        if ( $sub_cnt <= $index ) return -1;
        $this->map[$this->subList[$index]->email] = 1;
        echo json_encode($this->subList[$index])."\n";
        return $index;
    }

    public function get_new_smtp()
    {
        $dao                = get_new_campaignDao();
        $camp               = $dao->getCampaign($this->id);
        $conn               = $dao->getConnection($camp->connection_id);

        $mail               = new PHPMailer(true);

        $mail->SMTPDebug    = 0;
        $mail->SMTPAuth     = true;
        $mail->Host         = $conn->smtp_server;
        $mail->Port         = $conn->smtp_port;
        $mail->SMTPSecure   = $conn->data_encryption;
        $mail->Username     = $conn->smtp_username;
        $mail->Password     = $conn->smtp_password;

        $mail->Subject      = $camp->subject;

        $mail->CharSet      = 'UTF-8';

        $mail->isSMTP       ();
        $mail->setFrom      ( $camp->from_email,        $camp->from_name );
        $mail->addReplyTo   ( $camp->reply_to_email,    $camp->from_name );
        $mail->msgHTML      ( $this->template,          dirname(__FILE__), true );


            if ($camp->attachment_link) {
                $mail->addAttachment(
                    dirname(__DIR__) . $camp->attachment_link,
                    substr(basename($camp->attachment_link), 0, -11)
                );
            }
        return $mail;
    }

    public function smtp_send_mail($index)
    {
        $pid = pcntl_fork();
        if ( $pid == -1)
        {
            exit("error forking...\n");
        }
        else if ($pid == 0)
        {
            $sub = $this->subList[$index];
            $mail = $this->get_new_smtp();

            try{
                if(!PHPMailer::validateAddress($sub->email)) {
                    throw new ErrorException("Email address ".$sub->email." is invalid -- aborting!");
                }
                //Set who the message is to be sent to
                $mail->addAddress($sub->email, $sub->name);

            }catch (ErrorException $e) {
                //$this->subList[$index]->status = SUB_STATE_NONE;
                echo $e->getMessage();
                exit();
            }
            exit();
        }else{
            //$this->subList[$index]->status = SUB_STATE_PENDING;
        }
    }

    public function send_by_amazon($index){

        $dao                    = get_new_campaignDao();
        $camp                   = $dao->getCampaign($this->id);
        $conn                   = $dao->getConnection($camp->connection_id);
        $sub                    = $this->subList[$index];


        $mail               = new PHPMailer(true);

        $mail->SMTPDebug    = 0;
        $mail->SMTPAuth     = true;
        $mail->Host         = $conn->smtp_server;
        $mail->Port         = $conn->smtp_port;
        $mail->SMTPSecure   = $conn->data_encryption;

            $mail->Subject      = $camp->subject;

        $mail->Body         = $this->template;
        $mail->CharSet      = 'UTF-8';

        $mail->isHTML(true);
        $mail->setFrom      ( $camp->from_email, $camp->from_name);
        $mail->addAddress   ( $sub->email,$sub->name);


            if ($camp->attachment_link && file_exists(dirname(__DIR__) . $camp->attachment_link)) {
                $mail->addAttachment(
                    dirname(__DIR__) . $camp->attachment_link,
                    substr(basename($camp->attachment_link), 0, -11)
                );
            }


        $mail->preSend();

        $args = [
            'Source'       => $camp->from_email,
            'Destinations' => [$sub->email],
            'RawMessage'   => [
                'Data' => $mail->getSentMIMEMessage()
            ]
        ];

        $param = array(
            'version'=> 'latest',
            'region' => $conn->region,
            'credentials' => [
                'key' => $conn->aws_access_key,
                'secret' => $conn->aws_secret_key
            ],
            'http' => [
                'verify' => '../service/ca-bundle.crt'
            ],
        );
        $client = \Aws\Ses\SesClient::factory($param);

        return $client->sendRawEmail($args);
    }

    public function amazon_send_mail($index, $mapping_id)
    {

        $pid = pcntl_fork();
        if ( $pid == -1 )
        {
            exit("error forking...\n");
        }else if ( $pid == 0)
        {
            $sub = $this->subList[$index];

            try{
                $result     = $this->send_by_amazon($index);


                    $msgId      = $result->get('MessageId');

                    $dao        = get_new_MappingDao();
                    $map        = $dao->getMappingFromID($mapping_id);
                    $map->message_id    = $msgId;
                    echo $map->id." ".$map->message_id." ".$map->campaign_id." ".$map->subscriber." ".$map->status."\n";
                    $dao->updateMapping($map);

            }catch (Exception $e){
                //$this->subList[$index]->status = SUB_STATE_NONE;
                echo $e->getMessage()."\n";
            }
            exit();
        }else{
            //$this->subList[$index]->status = SUB_STATE_PENDING;
        }
    }

    public function mail_sender($index)
    {
        $mapping_id = $this->getTemplate($index);

        switch ($this->conn_type)
        {
            case 'smtp':
                $this->smtp_send_mail($index);
                break;
            case 'amazon':
                $this->amazon_send_mail($index, $mapping_id);
                break;
            case 'send_grid':
                echo "send-grid\n";
                break;
            default:
                echo "default\n";
                break;
        }
    }

    public function start()
    {
        if ( $this->init() < 0 ) {
            echo $this->id.": already sent\n";
            return;
        }

        $index = -1;
        while(1) {
            $index = $this->get_next_subscriber($index);
            if ( $index < 0 ){
                break;
            }

            echo $this->id.": ".$index."->\n";
            if ( $this->subList[$index]->status == SUB_STATUS_SUBSCRIBED ){
                echo $this->subList[$index]->status." ".SUB_STATUS_SUBSCRIBED."\n";
                $this->mail_sender($index);
            }
            echo "<-$this->id: $index\n";

            sleep($this->delivery_delay);
        }
        $dao                    = get_new_campaignDao();
        $camp                   = $dao->getCampaign($this->id);
        $camp->status           = CAMPAIGN_IN_COMPLETED;
        $dao->updateCampaign($camp);
        echo "complete\n";
    }

}
//TODO
//get_new_CampaignDao is called too many times;

//===============Main function=================

Main();
