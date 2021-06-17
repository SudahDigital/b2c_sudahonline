<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function __construct(){
        // $this->middleware(function($request, $next){
            
        //     if(Gate::allows('manage-contact')) return $next($request);

        //     abort(403, 'Anda tidak memiliki cukup hak akses');
        // });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }

        $contact = DB::select("SELECT client_id AS id, client_number_contact, client_number_wa FROM clients WHERE client_id='".$clientID."'");
        return view($clientNM.'.contact.index', ['contact'=>$contact, 'client_slug'=>$clientNM]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }

        $contact_edit = DB::select("SELECT client_id AS id, client_number_contact, client_number_wa FROM clients WHERE client_id='".$clientID."' ");
        return view($clientNM.'.contact.edit',['contact_id'=>$contact_edit[0]->id, 'contact_1'=>$contact_edit[0]->client_number_contact,'contact_2'=>$contact_edit[0]->client_number_wa, 'client_slug'=>$clientNM]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $client)
    {
        // $client = \Route::current()->parameter('client_id');
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }

        $update = "UPDATE clients SET 
    					client_number_contact = '".$request->contact_no."',
    					client_number_wa = '".$request->wa_no."'
    				WHERE client_id = '".$clientID."'
    			";

    	$contact = DB::update($update);

    	if($contact){
        	return redirect()->route('contacts.edit', [$id, $clientNM])->with('status','Contact Succsessfully Updated');
    	}
        
        return redirect()->route('contacts.edit', [$id, $clientNM])->with('status','Contact failed Update');
    }
}