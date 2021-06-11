<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\product;
use App\order_product;
use App\Order;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {   
        $route = \Route::current()->parameter('client_id');
        return redirect($route.'/');
        
     }
}
