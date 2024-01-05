<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DashboardController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
    {
        // $ip = session()->get('ip');
        // $user = session()->get('user');
        // $password = session()->get('password');
        // $API = new RouterosAPI();
        // $API->debug = false;

        // if ($API->connect($ip, $user, $password)) {

        //     $hotspotactive = $API->comm('/ip/hotspot/active/print');
        //     $resource = $API->comm('/system/resource/print');
        //     $secret = $API->comm('/ppp/secret/print');
        //     $secretactive = $API->comm('/ppp/active/print');
        //     $interface = $API->comm('/interface/ethernet/print');
        //     $routerboard = $API->comm('/system/routerboard/print');
        //     $identity = $API->comm('/system/identity/print');


            // $data = [
            //     'totalsecret' => count($secret),
            //     'totalhotspot' => count($hotspotactive),
            //     'hotspotactive' => count($hotspotactive),
            //     'secretactive' => count($secretactive),
            //     'cpu' => $resource[0]['cpu-load'],
            //     'uptime' => $resource[0]['uptime'],
            //     'version' => $resource[0]['version'],
            //     'interface' => $interface,
            //     'boardname' => $resource[0]['board-name'],
            //     'freememory' => $resource[0]['free-memory'],
            //     'freehdd' => $resource[0]['free-hdd-space'],
            //     'model' => $routerboard[0]['model'],
            //     'identity' => $identity[0]['name'],
            // ];


            //return view('dashboard', $data);
            return view('dashboard');
        // } else {

        //     return redirect('failed');
      //  }
    }




}

error_reporting(0);
