<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
Use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;

class SalesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            
            if(Gate::allows('manage-sales')) return $next($request);

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
        $users = \App\User::with('cities')->where('roles','=','SALES')->get();//paginate(10);
        $filterkeyword = $request->get('keyword');
        $status = $request->get('status');
        if($filterkeyword){
            if($status){
                $users = \App\User::where('email','LIKE',"%$filterkeyword%")
                ->where('status', 'LIKE', "%$status%")->get();
                //->paginate(10);
            }
            else{
                $users = \App\User::where('email','LIKE',"%$filterkeyword%")->get();//paginate(10);
            }
        }
        if($status){
            $users = \App\User::where('status', 'Like', "%$status")->get();//paginate(10);
        }
        return view ('users.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_user = new \App\User;
        $new_user->name = $request->get('name');
        $new_user->email = $request->get('email');
        $new_user->password = \Hash::make($request->get('password'));
        //$new_user->username = $request->get('username');
        $new_user->roles = $request->get('roles');
        $new_user->address = $request->get('address');
        $new_user->phone = $request->get('phone');
        $new_user->sales_area = $request->get('sales_area');
        
        $new_user->save();
        if ( $new_user->save()){
            return redirect()->route('sales.create')->with('status','Sales Succsessfully Created');
        }else{
            return redirect()->route('sales.create')->with('error','Sales Not Succsessfully Created');
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
    public function edit($id)
    {
        $user = \App\User::findOrFail($id);
        return view('users.edit',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user =\App\User::findOrFail($id);
        $user->name = $request->get('name');
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');
        $user->sales_area = $request->get('sales_area');
        $user->status = $request->get('status');
        $user->save();
        return redirect()->route('sales.edit',[$id])->with('status','Sales Succsessfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = \App\User::findOrFail($id);
        $user->delete();
        return redirect()->route('sales.index')->with('status','Sales Succsessfully Delete');
    }

    public function ajaxSearch(Request $request){
        $keyword = $request->get('q');
        $cities = \App\City::where('city_name','LIKE',"%$keyword%")->get();
        return $cities;
    }

    public function export() {
        return Excel::download( new SalesExport(), 'Sales_Rep.xlsx') ;
    }
}
