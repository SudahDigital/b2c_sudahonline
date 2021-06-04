<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class OrderEditController extends Controller
{
    public function __construct(){
        $this->middleware(function($request, $next){
            
            if(Gate::allows('manage-edit-orders')) return $next($request);

            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }
    
    public function edit($id){
        $order = \App\Order::findOrFail($id);
        $products = \App\product::get();
        return view('orders.edit_order', ['order' => $order],['products' => $products]);
    }

    public function update(Request $request){
        if(count($request->id) > 0) {
            $sum = 0;
            foreach ($request->id as $i => $v){

                $data_order=array(
                    'product_id'=>$request->product_id[$i],
                    'quantity'=>$request->quantity[$i],
                  );
                $order_product = \App\order_product::where('id',$request->id[$i])->first();
                $order_product->update($data_order);
                $product = \App\product::where('id',$request->product_id[$i])->first();
                $price = $product->price;
                $jm = $price * $request->quantity[$i];
                $sum += $jm;
            }
                if($order_product->update($data_order)){
                  
                    $order = \App\Order::findOrFail($request->get('order_id'));
                    $order->username = $request->get('username');
                    $order->email = $request->get('email');
                    $order->address = $request->get('address');
                    $order->phone = $request->get('phone');
                    $order->total_price = $sum;
                    $order->status = $request->get('status');
                    $order->save();
                }
        }

        return redirect()->route('orders.index')->with('status', 'Order status succesfully updated');
    }
}
