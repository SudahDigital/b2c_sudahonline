<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    
    public function __construct(){
        $this->middleware(function($request, $next){
            
            if(Gate::allows('manage-users')) return $next($request);

            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
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
        $users = \App\User::get();//paginate(10);
        $filterkeyword = $request->get('keyword');
        $status = $request->get('status');
        if($filterkeyword){
            if($status){
                $users = \App\User::where('email','LIKE',"%$filterkeyword%")
                ->where('status', 'LIKE', "%$status%")
                ->where('client_id','=',$clientID)->get();
                //->paginate(10);
            }
            else{
                $users = \App\User::where('email','LIKE',"%$filterkeyword%")->get();//paginate(10);
            }
        }
        if($status){
            $users = \App\User::where('status', 'Like', "%$status")->get();//paginate(10);
        }
        return view ($clientNM.'.users.index',['users'=>$users, 'client_slug'=>$clientNM]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        return view($clientNM.'.users.create',['client_slug'=>$clientNM]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $new_user = new \App\User;
        $new_user->name = $request->get('name');
        $new_user->email = $request->get('email');
        $new_user->password = \Hash::make($request->get('password'));
        //$new_user->username = $request->get('username');
        $new_user->roles = json_encode($request->get('roles'));
        $new_user->address = $request->get('address');
        $new_user->phone = $request->get('phone');
        $new_user->client_id = $clientID;
        if($request->file('avatar')){
            $file = $request->file('avatar')->store('avatars','public');
        $new_user->avatar =$file;
        }
        $new_user->save();
        if ( $new_user->save()){
            return redirect()->route('users.create', $clientNM)->with('status','User Succsessfully Created');
        }else{
            return redirect()->route('users.create', $clientNM)->with('error','User Not Succsessfully Created');
        }
        
       
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
        $user = \App\User::findOrFail($id);
        return view($clientNM.'.users.edit',['user'=>$user, 'client_slug'=>$clientNM]);
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
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $user =\App\User::findOrFail($id);
        $user->name = $request->get('name');
        $user->status = $request->get('status');
        $user->roles = json_encode($request->get('roles'));
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');
        $user->client_id = $clientID;
        if($request->file('avatar')){
            if($user->avatar && file_exists(storage_path('app/public/'.$user->avatar)))
            {
                \Storage::delete('public/'.$user->avatar);
            }
            $file = $request->file('avatar')->store('avatars','public');
            $user->avatar =$file;
        }
        $user->save();
        return redirect()->route('users.edit',[$id, $clientNM])->with('status','User Succsessfully Update');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $user = \App\User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index', $clientNM)->with('status','User Succsessfully Delete');
    }
}
