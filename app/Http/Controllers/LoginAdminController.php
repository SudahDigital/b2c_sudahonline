<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $route = \Route::current()->parameter('client_id');
        // return redirect()->route('adminhome', [$route]);
        return view($route.'/home',['client_slug'=> $route]);
    }

    public function logoutadmin(Request $reauest)
    {
    	Auth::logout();
    	$categories = \App\Category::get();    
        $route = \Route::current()->parameter('client_id');
        return view($route.'.auth.login', ['categories'=> $categories, 'client_slug'=> $route]);
    }
}
