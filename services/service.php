<?php

error_reporting(E_ERROR | E_PARSE);

require_once ('./config.php');


function get_next_server_id($last_server_id){
  //echo 'getNextCamId--start';
  $con = mysqli_connect('localhost', 'root', 'root', 'ssher');
  @mysqli_query($con, 'SET CHARACTER SET utf8');
  @mysqli_query($con, "SET SESSION collation_connection ='utf8_general_ci'");
  if (!$con) {
    die('Database Connect Error: ' . @mysqli_connect_error());
  }

  $sql = "SELECT * FROM `servers` WHERE `id` > ".$last_server_id." ORDER BY `id` LIMIT 1";
  $result_fetch_servers = @mysqli_query($con, $sql);
  $total_results = @mysqli_num_rows($result_fetch_servers);

  if ($total_results ==1)
  {
    $row_fetch_server = @mysqli_fetch_assoc($result_fetch_servers);
    return $row_fetch_server['id'];
  }
  else {
      return -1;
  }
  @mysqli_close($con);
}

function Main()
{
    sleep(1);
    $last_server_id = -1;
    $get_time = file_get_contents("/tmp/checkfile.lock");
    $del_time = time()-$get_time;
    if ( $del_time < 2 ){
        echo "The service is running.\n";
        return ;
    }
    echo 'service starting..';

    while(1)
    {
        $id = get_next_server_id($last_server_id);

        if ( $id >= 0 )
        {
            $pid = pcntl_fork();
            if ( $pid == -1 )
            {
                exit("error forking...\n");
            } else if ( $pid == 0) {
                $server_item = new ServerProcess($id);
                $server_item->start();
                exit();
            }
            $last_server_id = $id;
        }
        sleep(1);
        file_put_contents("/tmp/checkfile.lock", time());
    }
    while(pcntl_waitpid(0, $status) != -1);
}

class ServerProcess
{
    private $id;
    private $current_act_id;
    private $is_connected;
    private $index=0;
    private $connection = null;
    private $password = null;
    private $hostname = null;
    private $username = null;
    private $path = null;
    public function __construct($id)
    {
        $this->id = $id;
        $this->index = 0;
    }

    public function get_cmd($index){
      $con = mysqli_connect('localhost', 'root', 'root', 'ssher');
      @mysqli_query($con, 'SET CHARACTER SET utf8');
      @mysqli_query($con, "SET SESSION collation_connection ='utf8_general_ci'");
      if (!$con) {
        die('Database Connect Error: ' . @mysqli_connect_error());
      }

      $sql = "SELECT * FROM `cmds` WHERE `ret` IS NULL AND `id` > ".$index." AND `server_id` = ".$this->id." ORDER BY `created_at` LIMIT 1";
      $result_fetch_servers = @mysqli_query($con, $sql);
      $total_results = @mysqli_num_rows($result_fetch_servers);

      if ($total_results == 1)
      {
        $row_fetch_server = @mysqli_fetch_assoc($result_fetch_servers);
        return $row_fetch_server;
      }
      else {
        return -1;
      }
      @mysqli_close($con);
    }

    public function update(){
      $con = mysqli_connect('localhost', 'root', 'root', 'ssher');
      @mysqli_query($con, 'SET CHARACTER SET utf8');
      @mysqli_query($con, "SET SESSION collation_connection ='utf8_general_ci'");
      if (!$con) {
        die('Database Connect Error: ' . @mysqli_connect_error());
      }

      $sql = "SELECT * FROM `servers` WHERE `id` = ".$this->id." LIMIT 1";
      $result_fetch_servers = @mysqli_query($con, $sql);
      $total_results = @mysqli_num_rows($result_fetch_servers);

      if ($total_results ==1 )
      {
        $row_fetch_server = @mysqli_fetch_assoc($result_fetch_servers);
        $this->password = $row_fetch_server['password'];
        $this->username = $row_fetch_server['username'];
        $this->host = $row_fetch_server['host'];
        $this->current_act_id = $row_fetch_server['current_act_id'];
        $this->is_connected = $row_fetch_server['is_connected'];
        $this->path = $row_fetch_server['current_path'];
        @mysqli_close($con);
        return 1;
      }
      @mysqli_close($con);
      return -1;
    }

    public function setResult($cmd_id, $res){
      $con = mysqli_connect('localhost', 'root', 'root', 'ssher');
      @mysqli_query($con, 'SET CHARACTER SET utf8');
      @mysqli_query($con, "SET SESSION collation_connection ='utf8_general_ci'");
      if (!$con) {
        die('Database Connect Error: ' . @mysqli_connect_error());
      }
      echo 'cmd_id:'.$cmd_id;
      echo $res;
      $sql = "UPDATE `cmds` SET `ret` = '".$res."' WHERE `id` = ".$cmd_id;
      @mysqli_query($con, $sql);
      @mysqli_close($con);
    }

    public function setupdatePath($res){
      $con = mysqli_connect('localhost', 'root', 'root', 'ssher');
      @mysqli_query($con, 'SET CHARACTER SET utf8');
      @mysqli_query($con, "SET SESSION collation_connection ='utf8_general_ci'");
      if (!$con) {
        die('Database Connect Error: ' . @mysqli_connect_error());
      }

      $sql = "UPDATE `servers` SET `current_path` = '".$res."' WHERE `id` = ".$this->id;
      @mysqli_query($con, $sql);
      @mysqli_close($con);
    }

    public function start()
    {
        while(1) {
            $this->update();
            $cmd = $this->get_cmd($this->index);

            if ( $cmd == -1 ){
                continue;
            }
            echo $cmd['id'].'-'.$cmd['action'];
            if ($cmd['action'] == 'connect'){
              $connection = ssh2_connect($this->host, 22);
              if (ssh2_auth_password($connection, $this->username, $this->password)){
                echo "Authentication Successful!\n";
                $this->connection = $connection;
                $this->path = null;
                $this->setResult($cmd['id'], 'Authentication Successful!');
              } else {
                echo "Authentication Failed!\n";
                $this->setResult($cmd['id'], 'Authentication Failed!');
              }
            } else if ($cmd['action'] == 'cmd'){
              $cmd_path = '';
              if ($this->path != null){
                $cmd_path = 'cd '.$this->path.PHP_EOL;
              }
              $stream = ssh2_exec($this->connection, $cmd_path.$cmd['cmd'].PHP_EOL.'pwd');
              stream_set_blocking($stream, true);
              $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
              $result = stream_get_contents($stream_out);

              if ($result == ''){
                $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
                stream_set_blocking($errorStream, 1);
                $result = stream_get_contents($errorStream);
                fclose($errorStream);
              }


              echo $cmd['cmd'].'result:'.$result;
              fclose($stream);
              $path_array = explode(PHP_EOL, $result);
              echo 'count:'.count($path_array);
              $path = $path_array[count($path_array)-2];
              if ($path){
                $this->setupdatePath($path);
                array_splice($path_array,count($path_array)-2);
                $result = join(PHP_EOL,$path_array);
                if ($result == ''){
                  $result = 'nothing';
                }
                $this->setResult($cmd['id'], $result);
              }
            }
            $this->index = $cmd['id'];
            sleep(1);
        }
    }
}

Main();
