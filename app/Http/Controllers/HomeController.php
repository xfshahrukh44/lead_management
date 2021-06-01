<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function check_for_ip(Request $request)
    {
        // dump(getIp());
        dd($_SERVER);
        // dd($request->ip());
        // $ip = '202.47.51.161';
        $remote_ip = '202.47.55.70';
        $server_ip = '208.109.41.232';
        // if('123' == env('IP')){
        // if($_SERVER['SERVER_ADDR'] == $server_ip || $_SERVER['REMOTE_ADDR'] == $remote_ip){
        if($_SERVER['REMOTE_ADDR'] == $remote_ip){
            return 'frue';
        }
        return 'false';
    }

    public function ip_auth(Request $request)
    {
        $user = "admin";
        $password = "UYp8vj9RP4Y9eX3c";
        if($request['user'] == $user && $request['password'] == $password){
            return 'frue';
        }
        return 'false';
    }
}
