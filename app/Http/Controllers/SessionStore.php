<?php

namespace App\Http\Controllers;
use App\Order;
use Illuminate\Http\Request;

class SessionStore extends Controller
{
    public function index(Request $request){
        //$lat = $request->get('lat');
        //$lng = $request->get('lng');
        //$url = 'http://maps.google.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&sensor=false';
        //$geocode = @file_get_contents($url);
        //$json = json_decode($geocode);
        //$address = $json->results[0]->formatted_address;
        //echo $address;
        //echo $lat,$lng;
    if($request->get('nm_toko_hide') != ""){
        $id_user = \Auth::user()->id;
        $cek_toko = $request->get('nm_toko_hide');
        $new_cust = new \App\Customer;
        $new_cust->name = $request->get('nm_cust_hide');
        $new_cust->phone = $request->get('no_telp_hide');
        $new_cust->phone_owner = $request->get('no_owner_hide');
        $new_cust->phone_store = $request->get('no_toko_hide');
        $new_cust->store_name = $request->get('nm_toko_hide');
        $new_cust->address = $request->get('alamat_hide');
        $new_cust->user_id = $id_user;
        $new_cust->status = 'NEW';
        $new_cust->save();
        if ( $new_cust->save()){
            $sel_cust = \App\Customer::where('store_name','LIKE BINARY',"%$cek_toko%")->first();
            $ses_order = new Order;
            $ses_order->user_loc = $request->get('user_loc');
            $ses_order->customer_id = $sel_cust->id;
            $request->session()->put('ses_order', $ses_order);
            }
        }
        else
        {
        $ses_order = new Order;
        //$ses_order->user_id = $request->get('user_id');
        //$ses_order->user_loc =$lat.','.$lng;
        $ses_order->user_loc = $request->get('user_loc');
        $ses_order->customer_id = $request->get('customer_id');
        $request->session()->put('ses_order', $ses_order);
        }
        return redirect('/sales_home');
    }

    public function clear(Request $request){
        $request->session()->forget('ses_order');
        return redirect('/sales_home');
    }
}
