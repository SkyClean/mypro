<?php

namespace App\Http\Controllers;
use Config;
use Illuminate\Http\Request;
use SSH;
use Log;
use App\Cmd;
use App\Act;
use App\Server;

class ConnectionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        // /$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function connection($id){


      $server = Server::where('id',$id)->first();

      $activity = Act::where('id', $server->current_act_id)->first();

      $servers = Server::all();
      $activities = Act::where('server_id', $server->id)->orderby('created_at', 'desc')->paginate(20);

      Log::info($activity);
      return view('connect', [
        'server' => $server,
        'activities' => $activities,
        'servers' => $servers,
        'activity' => $activity
      ]);
    }

    public function makeconnect(Request $request, $id){
      $server = Server::find($id);
      if (!$server->is_connected){
        $act_name = $request->input('act_name');
        $act_description = $request->input('act_description');
        $server_id = $id;

        $act = Act::create([
          'server_id' => $id,
          'name' => $act_name,
          'description' => $act_description
        ]);

        $cmd = Cmd::create([
          'server_id'  => $id,
          'action' => 'connect',
          'act_name' => $act_name,
          'act_description' => $act_description,
          'act_id' => $act->id
        ]);

        $server->is_connected = true;
        $server->current_act_id = $act->id;
        $server->current_path = NULL;
        $server->save();
        return $cmd->id;
      }

      return 'already connected';
    }

    public function disconnect(Request $request, $id){
      $server = Server::find($id);
      $server->is_connected = false;
      $server->session_log = '';
      $server->save();
      return 'success';
    }

    public function sessionlogUpdate(Request $request, $id){

      $server = Server::find($id);
      $content = $request->input('content');
      Log::info('sessionlogUpdate');
      Log::info($content);
      $server->session_log = $content;
      $server->save();
      return 'success';
    }

    public function getcmd(Request $request, $id){
      $cmd_id = $request->input('cmd_id');

      if ($cmd_id == 0) {
          return 'wait';
      }

      $cmd = Cmd::where('id', $cmd_id)->first();
      if ($cmd->ret) return $cmd->ret;
      else return 'wait';
    }

    public function cmd(Request $request, $id){
      $server = Server::find($id);
      if ($server->is_connected){
        $cmd = $request->input('cmd');
        $server_id = $id;

        $cmd = Cmd::create([
          'server_id'  => $id,
          'action' => 'cmd',
          'cmd' => $cmd,
          'act_id' => $server->current_act_id
        ]);

        $server->is_connected = true;
        $server->save();
        return $cmd->id;
      }
      return 'not connected';
    }
}
