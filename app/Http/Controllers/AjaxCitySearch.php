<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxCitySearch extends Controller
{
    public function ajax_city(Request $request){
        $keyword = $request->get('q');
        $cities = \App\City::where('type','=','Kota')
                ->where('city_name','LIKE',"%$keyword%")
                ->orderBy('display_order','ASC')
                ->orderBy('postal_code','ASC')
                ->get();
        return $cities;
    }

    public function ajax_store(Request $request){
        /*$keyword = $request->get('q');
        $store = \App\Customer::where('store_name','LIKE',"%$keyword%")
        ->orWhere('store_code','LIKE',"%$keyword%")->get();
        return $store;*/
        $search = $request->get('search');
        $city_id = $request->get('city_id');
        if($city_id == ''){
            if($search == ''){
                $store = \App\Customer::all();
            }else{
                $store = \App\Customer::where('store_name','LIKE',"%$search%")
                        ->orWhere('store_code','LIKE',"%$search%")->get();
                //\App\Customer::where('city_id','=',$city_id)
                        //->where('store_name','LIKE',"$search")
                        //->orWhere('store_code','LIKE',"$search")
                        //->get();
            }
        }else{
            if($search == ''){
                $store = \App\Customer::where('city_id',$city_id)->get();
            }else{
                $store = \App\Customer::where('city_id',$city_id)
                        ->where('store_name','LIKE',"%$search%")
                        ->orWhere('store_code','LIKE',"%$search%")->get();
                //\App\Customer::where('city_id','=',$city_id)
                        //->where('store_name','LIKE',"$search")
                        //->orWhere('store_code','LIKE',"$search")
                        //->get();
            }
        }

        $response = array();
        foreach($store as $toko){
            $response[] = array(
                "id"=>$toko->id,
                "text"=>$toko->store_code.' - '.$toko->store_name
            );
        }

        return response()->json($response);
    }
}
