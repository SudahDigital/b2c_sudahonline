<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginAdminController extends Controller
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
        // $route = \Route::current()->parameter('client_id');
        // return view($route.'.home',['client_slug'=> $route]);

        $client = auth()->user()->client_id;
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_id = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $categories = \App\Category::get();    
        // return redirect()->route('adminhome', $clientNM);
        // return view($clientNM.'.home', ['categories'=> $categories,'client_slug'=> $clientNM]);
        // echo "jalan2".$client;exit();
        return view('home', ['categories'=> $categories,'client_slug'=> $clientNM]);
    }

    public function logoutadmin(Request $request)
    {
    	Auth::logout();
    	$categories = \App\Category::get();    
        $route = \Route::current()->parameter('client_id');

        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug, clients.client_name FROM clients 
                    WHERE clients.client_slug = '$route'"); 

        $clientID = $clientSL = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientSL = $sql_client[0]->client_slug;
            $clientNM = $sql_client[0]->client_name;
        }
        return view('admin.auth.login', ['categories'=> $categories, 'client_slug'=> $route, 'client_name'=> $clientNM]);
        // return view($route.'.auth.login', ['categories'=> $categories, 'client_slug'=> $route]);
    }
}
