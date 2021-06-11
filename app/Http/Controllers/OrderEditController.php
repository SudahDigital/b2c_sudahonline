<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderEditController extends Controller
{
    public function __construct(){
        $this->middleware(function($request, $next){
            
            if(Gate::allows('manage-edit-orders')) return $next($request);

            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }
    
    public function edit($id, $client){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $order = \App\Order::findOrFail($id);
        $products = \App\product::get();
        return view($clientNM.'.orders.edit_order', ['order' => $order],['products' => $products, 'client_slug' => $clientNM]);
    }

    public function update(Request $request, $client){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        if(count($request->id) > 0) {
            $sum = 0;
            foreach ($request->id as $i => $v){
                $product = \App\product::where('id',$request->product_id[$i])->where('client_id','=',$clientID)->first();
                $data_order=array(
                    'product_id'=>$request->product_id[$i],
                    'price_item'=>$product->price,
                    'price_item_promo'=>$product->price_promo,
                    'discount_item'=>$product->discount,
                    'quantity'=>$request->quantity[$i],
                );
                $price = $product->price - ($product->price * ($product->discount / 100));
                $order_product = \App\order_product::where('id',$request->id[$i])->where('client_id','=',$clientID)->first();
                $order_product->update($data_order);
                $jm = $price * $request->quantity[$i];
                $sum += $jm;
            }
                if(($order_product->update($data_order)) && ($request->get('status') != 'CANCEL')){
                    if($request->get('id_voucher') != ""){
                        $vouchers = \App\Voucher::findOrFail($request->get('id_voucher'));
                        $no_disc = DB::table('order_product')
                                    ->where('order_product.order_id','=',$request->get('order_id'))
                                    ->where('order_product.discount_item','=','0')//->get();
                                    ->where('order_product.client_id','=',$clientID)
                                    ->sum(DB::raw('order_product.price_item * order_product.quantity'));
                        if( $vouchers->type == 1){
                            $potongan = $no_disc * ($vouchers->discount_amount / 100);
                            $total = $sum - $potongan;
                        }
                        else if ($vouchers->type == 2)
                        {
                            $total = $sum - $vouchers->discount_amount;
                        }
                        $order = \App\Order::findOrFail($request->get('order_id'));
                        $order->username = $request->get('username');
                        $order->email = $request->get('email');
                        $order->address = $request->get('address');
                        $order->phone = $request->get('phone');
                        $order->total_price = $total;
                        $order->status = $request->get('status');
                        $order->save();
                    }else{
                        $order = \App\Order::findOrFail($request->get('order_id'));
                        $order->username = $request->get('username');
                        $order->email = $request->get('email');
                        $order->address = $request->get('address');
                        $order->phone = $request->get('phone');
                        $order->total_price = $sum;
                        $order->status = $request->get('status');
                        $order->save();
                    }
                    
                }else{
                    $order = \App\Order::findOrFail($request->get('order_id'));
                    $order->username = $request->get('username');
                    $order->email = $request->get('email');
                    $order->address = $request->get('address');
                    $order->phone = $request->get('phone');
                    $order->total_price = $sum;
                    $order->status = $request->get('status');
                    $order->save();
                    if($order->save()){
                        $cek_quantity = \App\Order::with('products')->where('client_id','=',$clientID)->where('id',$request->get('order_id'))->get();
                        foreach($cek_quantity as $q){
                            foreach($q->products as $p){
                                $up_product = \App\product::findOrfail($p->pivot->product_id);
                                $up_product->stock += $p->pivot->quantity;
                                $up_product->save();
                                }
                            }
                    }
                }
        }

        return redirect()->route('orders.index', $clientNM)->with('status', 'Order status succesfully updated');
    }
}
