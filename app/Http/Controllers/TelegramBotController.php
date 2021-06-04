<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    public function updatedActivity()
    {
        $activity = Telegram::getUpdates();
        dd($activity);
    }

    public function pesan(Request $request){
        $user_id = \Auth::user()->id;
        $id = $request->get('id');
        $cek_order = DB::select("SELECT order_product.order_id, order_product.product_id,order_product.quantity, 
                    products.stock, products.description FROM products,order_product WHERE order_product.product_id = products.id AND 
                    order_product.quantity > products.stock AND order_product.order_id = '$id'");
        $count_cek = count($cek_order);
        if($count_cek > 0){
            return view('errors/error_telegram');
        }else{
            $cek_quantity = Order::with('products')->where('id',$id)->get();
            foreach($cek_quantity as $q){
                foreach($q->products as $p){
                    $up_product = product::findOrfail($p->pivot->product_id);
                    $up_product->stock -= $p->pivot->quantity;
                    $up_product->save();
                    }
                }
            $user = User::findOrfail($user_id);
            $ses_order = $request->session()->get('ses_order');
            $customer = Customer::findOrfail($ses_order->customer_id);
            $city = City::findOrfail($user->city_id);
            $customer_id = $ses_order->customer_id;
            $orders = Order::findOrfail($id);
            $orders->customer_id = $customer_id;
            
            if($request->get('voucher_code_hide_modal') != ""){
                $keyword = $request->get('voucher_code_hide_modal');
                $vouchers_cek = \App\Voucher::where('code','=',"$keyword")->first();
                $orders->id_voucher = $vouchers_cek->id;
                $orders->total_price = $request->get('total_pesanan');
            }
            else{
                $orders->id_voucher = NULL;
            }
            $orders->save();
            $total_pesanan = $request->get('total_pesanan');
            if($request->get('voucher_code_hide_modal')!= ""){
                $sum_novoucher = $request->get('total_novoucher');
                $keyword = $request->get('voucher_code_hide_modal');
                $vouchers_cek = \App\Voucher::where('code','=',"$keyword")->first();
                $code_name = $vouchers_cek->name;
                $type = $vouchers_cek->type;
                $disc_amount = $vouchers_cek->discount_amount;
                $vouchers = \App\Voucher::findOrFail($vouchers_cek->id);
                $vouchers->uses +=1;
                $vouchers->save();
            }
            //$total_ongkir  = 15000;
            $total_bayar  = $total_pesanan;
            $href='Hello Admin Mega Cools,

<b>Detail Sales</b> 
Nama : '.$user->name.',
Email : '.$user->email.',
No. Hp :' .$user->phone.',
Sales Area :' .$city->city_name.',

<b>Detail Pelanggan</b> 
Nama  : '.$customer->name.',
Email : '.$customer->email.',
No. Telp : '.$customer->phone.',
Nama Toko : '.$customer->store_name.',
Alamat : '.$customer->address.',

<b>Detail Pesanan</b>';
if($orders->save()){
$pesan = DB::table('order_product')
        ->join('orders','order_product.order_id','=','orders.id')
        ->join('products','order_product.product_id','=','products.id')
        ->where('orders.id','=',"$id")
        ->get();
foreach($pesan as $key=>$tele){
$href.='
*'.$tele->Product_name.' (Qty :'.$tele->quantity.')';
}
if($request->get('voucher_code_hide_modal')!= ""){
    if ($type == 1){
        $info_harga = '<b>Total Pesanan</b> : Rp.'.number_format(($sum_novoucher), 0, ',', '.');
    }else{
        $info_harga = '<b>Total Pesanan</b> : Rp.'.number_format(($sum_novoucher), 0, ',', '.');
    }
}
else{
    $info_harga = '<b>Total Pesanan</b> : Rp.'.number_format(($total_pesanan), 0, ',', '.');
}
            $text_wa=$href.'
            
'.$info_harga;
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID', '1179259045'),
                'parse_mode' => 'HTML',
                'text' => $text_wa
            ]);
                //$url = "https://api.whatsapp.com/send?phone=6282311988000&text=$text_wa";
                //return Redirect::to($url);
                Alert::success('', 'Pesanan berhasil dikirim');
                return redirect()->route('home_customer');    
            }
        }
        
        
    }
}
