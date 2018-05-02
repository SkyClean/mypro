<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Server;
use App\Act;
use Redirect;
use Log;

class ActivityController extends Controller
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
     public function activities(Request $request)
     {

       $servers = Server::all();
       $query = $request->input('query');

       if($query == null)
         $query = '';

         $activities = Act::where('name', 'like', '%'.$query.'%')->paginate(15);
         foreach($activities as $item){
           $server = Server::where('id', $item->server_id)->first();
           $item->server = $server->host;
         }
           return view('activities', [
               'activities' => $activities,
               'search' => $query,
               'servers' => $servers
           ]);
    }
}
