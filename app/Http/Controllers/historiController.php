<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\product;


class historiController extends Controller
{   
    public function index(Request $request){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }

        // $tes = \Route::current()->parameter('client_id');
        $ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $session_id = $ses_id.$clientIP;
        //$session_id = $request->header('User-Agent');
        $categories = \App\Category::all();//paginate(10);
        $orders = \App\Order::with('products')->whereNotNull('username')->where('session_id','=',"$session_id")->where('client_id','=',"$clientID")->paginate(5);
        $order_count = $orders->count();
        
        $data=['order_count'=>$order_count, 'orders'=>$orders,'categories'=>$categories,'client_slug'=>$clientNM];
       
        return view('customer.riwayat_pesanan',$data);

    }
        
}
