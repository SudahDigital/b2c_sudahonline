<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExportMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $status = $request->get('status');
        if($status){
        $orders = \App\Order::with('products')->whereNotNull('username')
        ->where('status',strtoupper($status))
        ->orderBy('id', 'DESC')->get();//paginate(10);
        }
        else{
            $orders = \App\Order::with('products')->whereNotNull('username')
            ->orderBy('id', 'DESC')->get();
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
      
        $order->status = $request->get('status');

        $order->save();

        if(($order->save()) && ($request->get('status') == 'CANCEL')){
            $cek_quantity = \App\Order::with('products')->where('id',$id)->get();
            foreach($cek_quantity as $q){
                foreach($q->products as $p){
                    $up_product = \App\product::findOrfail($p->pivot->product_id);
                    $up_product->stock += $p->pivot->quantity;
                    $up_product->save();
                    }
                }
        }
      
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
        return view('orders.detail', ['order' => $order]);
    }

    public function export_mapping() {
        return Excel::download( new OrdersExportMapping(), 'Orders.xlsx') ;
    }
}
