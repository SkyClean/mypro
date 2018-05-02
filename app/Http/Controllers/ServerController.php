<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Server;
use App\Act;
use Redirect;
use Log;
class ServerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function servers(Request $request)
     {

       $query = $request->input('query');


       if($query == null)
         $query = '';

         $servers = Server::where('name', 'like', '%'.$query.'%')->paginate(50);
         foreach($servers as $item){
           $activities = Act::where('server_id', $item->id)->get();
           $item->act_count = count($activities);
         }
           return view('servers', [
               'servers' => $servers,
               'search' => $query,
           ]);
       }

       public function newServer()
       {
           $servers = Server::paginate(50);
           return view('serverEdit', [
               'server' => array('id'=>null, 'name'=>'', 'host'=>'', 'username'=>'', 'password'=>''),
               'servers' => $servers
           ]);
       }

       public function editServer(Request $request, $id)
       {
         $servers = Server::paginate(50);
           return view('serverEdit', [
               'server' => Server::findOrNew($id),
               'servers' => $servers
           ]);
       }

       public function postEdit(Request $request)
       {
           $server=[];
           if($request->input('id') != '') {
               $server = Server::findOrNew($request->input('id'));
               $servername = $request->input('name');
               $server->username  = $request->input('username');
               $server->host  = $request->input('host');
               $server->name = $servername;
               if ($request->input('isResetPassword'))
               {
                 Log::info($request->input('reset_password'));
                 $server->password = $request->input('reset_password');
               }

               $server->save();
             } else {
               $exists = Server::where('name', $request->input('name'))->get();
               if(sizeof($exists) > 0) {
                 return Redirect::back()->withErrors("This name already used.");
               }
               $servername = $request->input('name');
               $user = Server::create([
                 'name' => $servername,
                 'password' => $request->input('password'),
                 'host' => $request->input('host'),
                 'username' => $request->input('username'),
               ]);
             }
             return redirect()->to('servers');
       }

       public function destroy($id)
       {
       	$u = Server::findOrNew($id);

           $u->delete();
           $ret = array("result"=>"ok");
           return json_encode($ret);
       }
}
