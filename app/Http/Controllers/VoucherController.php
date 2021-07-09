<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function __construct(){
        $this->middleware(function($request, $next){
            
            if(Gate::allows('manage-vouchers')) return $next($request);

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
        $status = $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';
        if($status){
        $vouchers = \App\Voucher::where('name','LIKE',"%$keyword%")->where('client_id','=',$clientID)
        ->where('status',strtoupper($status))->get();//->paginate(10);
        }
        else
            {
            $vouchers = \App\Voucher::where('name','LIKE',"%$keyword%")->where('client_id','=',$clientID)->get();
            //->paginate(10);
            }
        // return view($clientNM.'.vouchers.index', ['vouchers'=> $vouchers, 'client_slug'=> $clientNM]);
            return view('vouchers.index', ['vouchers'=> $vouchers, 'client_slug'=> $clientNM]);
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
        // return view($clientNM.'.vouchers.create', ['client_slug'=> $clientNM]);
        return view('vouchers.create', ['client_slug'=> $clientNM]);
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
        $new_voucher = new \App\Voucher;
        $new_voucher->code = $request->get('code');
        $new_voucher->name = $request->get('name');
        $new_voucher->description = $request->get('description');
        $new_voucher->type = $request->get('type');
        $new_voucher->discount_amount = $request->get('discount_amount');
        $originalDate = $request->get('expires_at');
        //$newDate = date("Y-m-d", strtotime($originalDate));
        $new_voucher->expires_at = $originalDate;
        $new_voucher->max_uses = $request->get('max_uses');
        $new_voucher->client_id = $clientID;
        $new_voucher->save();

        if($request->get('save_action') == 'SAVE'){
          return redirect()
                ->route('vouchers.create', $clientNM)
                ->with('status', 'Vouchers successfully saved');
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
        $voucher = \App\Voucher::where('client_id', $clientID)->findOrFail($id);
        // return view($clientNM.'.vouchers.edit', ['voucher' => $voucher, 'client_slug'=> $clientNM]);
        return view('vouchers.edit', ['voucher' => $voucher, 'client_slug'=> $clientNM]);
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
        $voucher = \App\Voucher::where('client_id', $clientID)->findOrFail($id);
        $voucher->name = $request->get('name');
        $voucher->description = $request->get('description');
        $voucher->code = $request->get('code');
        $voucher->type = $request->get('type');
        $voucher->discount_amount = $request->get('discount_amount');
        $originalDate = $request->get('expires_at');
        //newDate = date("Y-m-d", strtotime($originalDate));
        $voucher->expires_at = $originalDate;
        $voucher->max_uses = $request->get('max_uses');
        $voucher->client_id = $clientID;
        $voucher->save();
        return redirect()->route('vouchers.edit', [$voucher->id, $clientNM])->with('status',
        'Voucher successfully updated');
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
        $vouchers = \App\Voucher::where('client_id', $clientID)->findOrFail($id);
        $vouchers->delete();
        return redirect()->route('vouchers.index', $clientNM)->with('status', 'Voucher moved to
        trash');
    }

    public function trash($client){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $vouchers = \App\Voucher::onlyTrashed()->get();//->paginate(10);

        // return view($clientNM.'.vouchers.trash', ['vouchers' => $vouchers, 'client_slug'=>$clientNM]);
        return view('vouchers.trash', ['vouchers' => $vouchers, 'client_slug'=>$clientNM]);
    }

    public function ajaxSearch(Request $request){
        $keyword = $request->get('code');
        $vouchers = \App\Voucher::where('code','=',"$keyword")->count();
        if ($vouchers > 0) {
            echo "taken";	
          }else{
            echo 'not_taken';
          }
    }

    public function restore($id, $client){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $voucher = \App\Voucher::where('client_id', $clientID)->withTrashed()->findOrFail($id);
        if($voucher->trashed()){
            $voucher->restore();
        return redirect()->route('vouchers.trash', $clientNM)->with('status', 'Voucher successfully restored');
        } else {
        return redirect()->route('vouchers.trash', $clientNM)->with('status', 'Voucher is not in trash');
        }
    }

    public function deletePermanent($id, $client){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $voucher = \App\Voucher::where('client_id', $clientID)->withTrashed()->findOrFail($id);
        if(!$voucher->trashed()){
        return redirect()->route('vouchers.trash', $clientNM)->with('status', 'Voucher is not in trash!')->with('status_type', 'alert');
        } else {
        $voucher->forceDelete();
        return redirect()->route('vouchers.trash', $clientNM)->with('status', 'Voucher permanently deleted!');
        }

    }

}
