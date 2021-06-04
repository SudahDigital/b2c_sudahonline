<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExportMapping;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware(function($request, $next){
            
            if(Gate::allows('manage-orders')) return $next($request);

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
        $user =\Auth::user()->roles;
        $id_user =\Auth::user()->id;
        //dd($user);
        if($user == 'SUPERVISOR'){
            $status = $request->get('status');
            if($status){
            $stts = strtoupper($status);
            $orders = \DB::select("SELECT * FROM orders WHERE customer_id IS NOT NULL AND status='$stts' AND EXISTS 
                    (SELECT spv_id,sls_id FROM spv_sales WHERE 
                    spv_sales.sls_id = orders.user_id AND spv_id='$id_user') ORDER BY created_at DESC");
            }
            else{
                $orders = \DB::select("SELECT * FROM orders WHERE customer_id IS NOT NULL AND EXISTS 
                (SELECT spv_id,sls_id FROM spv_sales WHERE 
                spv_sales.sls_id = orders.user_id AND spv_id='$id_user') ORDER BY created_at DESC");
                //dd($orders);
            }
        }
        else{
            $status = $request->get('status');
            if($status){
            $orders = \App\Order::with('products')->whereNotNull('customer_id')
            ->where('status',strtoupper($status))
            ->orderBy('created_at', 'DESC')->get();//paginate(10);
            }
            else{
                $orders = \App\Order::with('products')->with('customers')->whereNotNull('customer_id')
                ->orderBy('created_at', 'DESC')->get();
            //dd($orders);
            }
        }
        
        return view('orders.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        $order = \App\Order::findOrFail($id);
        $dateNow = date('Y-m-d H:i:s');
        $status = $request->get('status');
        if($status == 'PROCESS'){
            $order->status = $status;
            $order->process_time = $dateNow;
            //$order->save();
        }else if($status == 'FINISH'){
            $order->status = $status;
            $order->finish_time = $dateNow;
            //$order->save();
        }else if($status == 'CANCEL'){
            $order->status = $status;
            $order->cancel_time = $dateNow;
        }else{
            $order->status = $status;
        }
        $order->save();
        
        return redirect()->route('orders.detail', [$order->id])->with('status', 'Order status succesfully updated');
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
        $order = \App\Order::findOrFail($id);
        $paket_list = \DB::table('order_product')
                ->join('pakets','pakets.id','=','order_product.paket_id')
                ->join('groups','groups.id','=','order_product.group_id')
                ->where('order_id',$id)
                ->whereNotNull('paket_id')
                ->whereNotNull('group_id')
                ->whereNull('bonus_cat')
                ->distinct()
                ->get(['paket_id','group_id']);
                //dd($paket_list);
        return view('orders.detail', ['order' => $order, 'paket_list'=>$paket_list]);
    }

    public function export_mapping() {
        return Excel::download( new OrdersExportMapping(), 'Orders.xlsx') ;
    }
}
