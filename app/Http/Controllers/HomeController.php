<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Server;
class HomeController extends Controller
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
    public function index()
    {
        $servers = Server::paginate(50);
        $search = "";
        return view('servers', [
          'servers' => $servers,
          'search' => $search
        ]);
    }
}
