<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\product;


class historiController extends Controller
{   
    public function index(Request $request){
        $ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $session_id = $ses_id.$clientIP;
        //$session_id = $request->header('User-Agent');
        $categories = \App\Category::all();//paginate(10);
        $orders = \App\Order::with('products')->whereNotNull('username')->where('session_id','=',"$session_id")->paginate(5);
        $order_count = $orders->count();
        
        $data=['order_count'=>$order_count, 'orders'=>$orders,'categories'=>$categories,];
       
        return view('customer.riwayat_pesanan',$data);

    }
        
}
