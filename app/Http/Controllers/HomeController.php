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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        if ((auth()->user()->roles == 'SUPERADMIN') || (auth()->user()->roles == 'ADMIN') || (auth()->user()->roles == 'SUPERVISOR')) {
            //return view('home');
            $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
            return redirect()->route('home_admin',[$client->client_slug]);
        }else if (auth()->user()->roles == 'SALES') {
            return redirect('/sales_home');
        }
        //return view('home');
    }

    public function home_admin(){
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        return view('home',['client'=>$client]);
    }
}
