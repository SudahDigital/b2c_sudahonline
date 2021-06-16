<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class AjaxSearchController extends Controller
{
    public function ajaxSearchCategories(Request $request){
            $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client'"); 

            $clientID = $clientNM = "";
            if(count($sql_client) > 0){
                $clientID = $sql_client[0]->client_id;
                $clientNM = $sql_client[0]->client_slug;
            }
            $keyword = $request->get('q');
            $categories = \App\Category::where('name','LIKE',"%$keyword%")->where('client_id','=',$clientID)->get();
            return $categories;
        }
}
