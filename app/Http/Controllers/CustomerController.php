<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomersImport;
use App\Exports\CitiesExport;
use App\Exports\CustomerExport;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            
            if(Gate::allows('manage-customers')) return $next($request);

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
        $customers = \App\Customer::with('users')->with('cities')->where('status','!=','NEW')->orderBy('id','DESC')->get();//paginate(10);
        //$filterkeyword = $request->get('keyword');
        $status = $request->get('status');
        
        if($status){
            $customers = \App\Customer::with('users')->with('cities')->where('status', 'Like', "%$status")->orderBy('id','DESC')->get();//paginate(10);
        }
        return view ('customer_store.index',['customers'=>$customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer_store.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_cust = new \App\Customer;
        $new_cust->store_code = $request->get('store_code');
        $new_cust->name = $request->get('name');
        $new_cust->email = $request->get('email');
        $new_cust->phone = $request->get('phone');
        $new_cust->phone_owner = $request->get('phone_owner');
        $new_cust->phone_store = $request->get('phone_store');
        $new_cust->store_name = $request->get('store_name');
        $new_cust->city_id = $request->get('city_id');
        $new_cust->address = $request->get('address');
        $new_cust->payment_term = $request->get('payment_term');
        $new_cust->user_id = $request->get('user_id');
        
        $new_cust->save();
        if ( $new_cust->save()){
            return redirect()->route('customers.create')->with('status','Customer Succsessfully Created');
        }else{
            return redirect()->route('customers.create')->with('error','Customer Not Succsessfully Created');
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
        $cust = \App\Customer::findOrFail($id);
        return view('customer_store.edit',['cust' => $cust]);
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
        $cust =\App\Customer::findOrFail($id);
        $cust->store_code = $request->get('store_code');
        $cust->name = $request->get('name');
        $cust->email = $request->get('email');
        $cust->phone = $request->get('phone');
        $cust->phone_owner = $request->get('phone_owner');
        $cust->phone_store = $request->get('phone_store');
        $cust->store_name = $request->get('store_name');
        $cust->city_id = $request->get('city_id');
        $cust->address = $request->get('address');
        $cust->payment_term = $request->get('payment_term');
        $cust->user_id = $request->get('user_id');
        $cust->save();
        return redirect()->route('customers.edit',[$id])->with('status','Customer Succsessfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detail($id)
    {
        $customer = \App\Customer::findOrFail($id);
        return view('customer_store.detail', ['customer' => $customer]);
    }

    public function deletePermanent($id){

        $cust = \App\Customer::findOrFail($id);
        $order_cust = \App\Order::where('customer_id','=',"$cust->id")->count();
        if($order_cust > 1){
            return redirect()->route('customers.index')->with('error', 'Cannot be deleted, because this data already exists in orders');
        }
        else {
        $cust->forceDelete();
        return redirect()->route('customers.index')->with('status', 'Customer permanently deleted!');
        }

    }

    public function ajaxSearch(Request $request){
        $keyword = $request->get('code');
        $cust = \App\Customer::where('store_code','=',"$keyword")->count();
        if ($cust > 0) {
            echo "taken";	
          }else{
            echo 'not_taken';
          }
    }

    public function ajaxCitySearch(Request $request){
        $keyword = $request->get('q');
        $cities = \App\City::where('type','=','Kota')
                ->where('city_name','LIKE',"%$keyword%")
                ->orderBy('display_order','ASC')
                ->orderBy('postal_code','ASC')
                ->get();
        return $cities;
    }

    public function ajaxUserSearch(Request $request){
        $keyword = $request->get('q');
        $user = \App\User::where('roles','=','SALES')->where('name','LIKE',"%$keyword%")->get();
        return $user;
    }

    public function export() {
        return Excel::download( new CustomerExport(), 'Customers.xlsx') ;
    }

    public function exportCity() {
        return Excel::download( new CitiesExport(), 'City List.xlsx') ;
    }

    public function import(){
        return view('customer_store.import_customers');
    }

    public function import_data(Request $request){
        \Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx"
        ])->validate();
            
        $data = Excel::import(new CustomersImport, request()->file('file'));
        return redirect()->route('customers.import')->with('status', 'File successfully upload');
    }
}
