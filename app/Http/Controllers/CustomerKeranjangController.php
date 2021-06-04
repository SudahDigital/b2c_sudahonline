<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\product;
use App\order_product;
use App\Order;
use App\User;
use App\Customer;
use App\City;
use Telegram\Bot\Laravel\Facades\Telegram;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerKeranjangController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        
    }

    public function index(Request $request, $cat = null)
    {   
        $id_user = \Auth::user()->id;
        $banner_active = \App\Banner::orderBy('position', 'ASC')->first();
        $banner = \App\Banner::orderBy('position', 'ASC')->limit(5)->get();
        $categories = \App\Category::all();//paginate(10);
        $paket = \App\Paket::all()->first();//paginate(10);
        $cat_count = $categories->count();
        $stock_status= DB::table('product_stock_status')->first();
        $top_product = product::with('categories')
        ->where('top_product','=','1')
        ->where('status','=','PUBLISH')
        ->orderBy('top_product','ASC')->get();
        if($cat){
            //$category_id = $request->get('cats');
            $product = \App\product::whereHas('categories',function($q) use ($cat){
                return $q->where('category_id','=',$cat)
                ->where('status','=','PUBLISH');
                //->where('top_product','=','0');
                })->get();
        }else{
            $product = product::with('categories')
            //->where('top_product','=','0')
            ->where('status','=','PUBLISH')
            ->get();//->paginate(6);
        }
        $top_count = $top_product->count();
        $count_data = $product->count();
        $keranjang = DB::select("SELECT orders.user_id, orders.status,orders.customer_id, 
                    products.Product_name, products.image, products.price, products.discount,
                    products.price_promo, order_product.id, order_product.order_id,
                    order_product.product_id,order_product.quantity,order_product.group_id 
                    FROM order_product, products, orders WHERE order_product.group_id IS NULL
                    AND orders.id = order_product.order_id AND 
                    order_product.product_id = products.id AND orders.status = 'SUBMIT' 
                    AND orders.user_id = '$id_user' AND orders.customer_id IS NULL ");
        /*$krj_paket = DB::select("SELECT orders.user_id, orders.status,orders.customer_id, 
                    products.Product_name, products.image, products.price, products.discount,
                    products.price_promo, order_product.id, order_product.order_id,
                    order_product.product_id,order_product.quantity,order_product.group_id,order_product.bonus_cat  
                    FROM order_product, products, orders WHERE order_product.group_id IS NOT NULL
                    AND orders.id = order_product.order_id AND order_product.bonus_cat IS NULL AND
                    order_product.product_id = products.id AND orders.status = 'SUBMIT' 
                    AND orders.user_id = '$id_user' AND orders.customer_id IS NULL ");*/
        $item = DB::table('orders')
                    ->where('user_id','=',"$id_user")
                    ->where('orders.status','=','SUBMIT')
                    ->whereNull('orders.customer_id')
                    ->first();
        $item_name = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('user_id','=',"$id_user")
                    ->whereNotNull('orders.customer_id')
                    ->first();
        
        $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('user_id','=',"$id_user")
                    ->whereNull('orders.customer_id')
                    ->distinct('order_product.product_id')
                    /*->whereNull('order_product.group_id')*/
                    ->count();
        $data=['total_item'=> $total_item, 
                'keranjang'=>$keranjang,
                'top_product'=>$top_product,
                'top_count'=>$top_count, 
                'product'=>$product,
                'item'=>$item,
                'item_name'=>$item_name,
                'count_data'=>$count_data,
                'paket'=>$paket,
                'categories'=>$categories,
                'cat_count'=>$cat_count,
                'banner'=>$banner,
                'banner_active'=>$banner_active,
                'stock_status'=>$stock_status
                ];
       
        return view('customer.content_customer',$data);
    }         
    
    public function simpan(Request $request){ 
        /*$ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $id = $ses_id.$clientIP;*/
        $id_user = \Auth::user()->id; 
        //$id = $request->header('User-Agent'); 
        $id_product = $request->get('Product_id');
        $quantity=$request->get('quantity');
        $price=$request->get('price');
        $cek_promo = product::findOrFail($id_product);
        $cek_order = Order::where('user_id','=',"$id_user")
        ->where('status','=','SUBMIT')->whereNull('customer_id')->first();
        if($cek_order !== null){
            $order_product = order_product::where('order_id','=',$cek_order->id)
            ->where('product_id','=',$id_product)->first();
            if($order_product!== null){
                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->quantity += $quantity;
                $order_product->save();
                $cek_order->total_price += $price * $quantity;
                $cek_order->save();
                }else{
                        $new_order_product = new order_product;
                        $new_order_product->order_id =  $cek_order->id;
                        $new_order_product->product_id = $id_product;
                        $new_order_product->price_item = $cek_promo->price;
                        $new_order_product->price_item_promo = $cek_promo->price_promo;
                        $new_order_product->discount_item = $cek_promo->discount;
                        $new_order_product->quantity = $quantity;
                        $new_order_product->save();
                        $cek_order->total_price += $price * $quantity;
                        $cek_order->save();
                }
        }
        else{

            $order = new \App\Order;
            $order->user_id = $id_user;
            //$order->quantity = $quantity;
            $order->invoice_number = date('YmdHis');
            $order->total_price = $price * $quantity;
            $order->status = 'SUBMIT';
            $order->save();
            if($order->save()){
                $order_product = new \App\order_product;
                $order_product->order_id = $order->id;
                $order_product->product_id = $request->get('Product_id');
                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->quantity = $request->get('quantity');
                $order_product->save();
            }

        }
        //return response()->json(['return' => 'some data']);    
        //$order->products()->attach($request->get('Product_id'));
        
        //return redirect()->back()->with('status','Product berhasil dimasukan kekeranjang');
    }

    /*public function min_order(Request $request){ 
        $ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $id = $ses_id.$clientIP; 
        //$id = $request->header('User-Agent'); 
        $id_product = $request->get('Product_id');
        $quantity=$request->get('quantity');
        $price=$request->get('price');
        $cek_promo = product::findOrFail($id_product);
        $cek_order = Order::where('session_id','=',"$id")
        ->where('status','=','SUBMIT')->whereNull('username')->first();
        if($cek_order !== null){
            $order_product = order_product::where('order_id','=',$cek_order->id)
            ->where('product_id','=',$id_product)->first();
            if(($order_product!== null) AND ($order_product->quantity > 1)){
                $order_product->quantity -= $quantity;
                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->save();
                $cek_order->total_price -= $price * $quantity;
                $cek_order->save();
                return redirect()->back()->with('status','Product berhasil dikurang dari keranjang');
                }else if(($order_product !== null) and ($order_product->quantity <= 1)){
                        $delete = DB::table('order_product')->where('id', $order_product->id)->delete();
                        if($delete){
                            $cek_order_product = order_product::where('order_id','=',$cek_order->id)->count();
                            if($cek_order_product < 1){
                                $delete_order = DB::table('orders')->where('id', $cek_order->id)->delete();
                            }
                            else{
                                $cek_order->total_price -= $price * $quantity;
                                $cek_order->save();
                            }
                            return redirect()->back()->with('status','Product berhasil dihapus dari keranjang');
                        }
                        
                    }
        }
        return redirect()->back();
       
    }*/

    public function tambah(Request $request){
           
        $id = $request->get('id_detil');
        $order_id = $request->get('order_id');
        $order_product = order_product::findOrFail($id);
        $cek_promo = product::findOrFail($order_product->product_id);
        $order_product->quantity += 1;
        $order_product->price_item = $cek_promo->price;
        $order_product->price_item_promo = $cek_promo->price_promo;
        $order_product->discount_item = $cek_promo->discount;
        $order_product->save();
        if($order_product->save()){
                $order = Order::findOrFail($order_id);
                $order->total_price += $request->get('price');
                $order->save();
        }
           
            
        //$order->products()->attach($request->get('Product_id'));
        
       // return redirect()->back()->with('status','Berhasil menambah produk');
    }

    public function kurang(Request $request){
        $id = $request->get('id_detil');
        $order_id = $request->get('order_id');
        $order_product = order_product::findOrFail($id);

        if($order_product->quantity < 2){
            $delete = DB::table('order_product')->where('id', $id)->delete();   
            if($delete)
            {   
                $cek_order_product = order_product::where('order_id','=',$order_id)->first();
                if($cek_order_product == null){
                    DB::table('orders')->where('id', $order_id)->delete();
                }
                else{
                        $order = Order::findOrFail($order_id);
                        $order->total_price -= $request->get('price');
                        $order->save();
                    }
                //return redirect()->back()->with('status','Berhasil menghapus produk dari keranjang');
            }
        }
        else{

            $order_product = order_product::findOrFail($id);
            $cek_promo = product::findOrFail($order_product->product_id);
            $order_product->price_item = $cek_promo->price;
            $order_product->price_item_promo = $cek_promo->price_promo;
            $order_product->discount_item = $cek_promo->discount;
            $order_product->quantity -= 1;
            $order_product->save();
            if($order_product->save()){
                $order = Order::findOrFail($order_id);
                $order->total_price -= $request->get('price');
                $order->save();
                //return redirect()->back()->with('status','Berhasil mengurangi produk');
            }
        } 
        
    }

    public function delete(Request $request){
        
        $id = $request->get('id');
        $product_id = $request->get('product_id');
        $order_id = $request->get('order_id');
        $quantity = $request->get('quantity');
        $price = $request->get('price');
        $order_product = order_product::where('order_id','=',$order_id)->count();
                        if($order_product <= 1){
                        $delete = DB::table('order_product')->where('id', $id)->delete();   
                        if($delete){
                            //DB::table('orders')->where('id', $order_id)->delete();
                            $orders = Order::findOrFail($order_id);
                            $orders->total_price = 0;
                            $orders->save();
                            }
                        }
                        else{
                             $delete2 = DB::table('order_product')->where('id', $id)->delete();
                             if($delete2){
                                $orders = Order::findOrFail($order_id);
                                $total_price = $price * $quantity;
                                $orders->total_price -= $total_price;
                                $orders->save();
                             }
                        }
                        return redirect()->back()->with('status','Product berhasil dihapus dari keranjang');
    }

    public function pesan(Request $request){
        $user_id = \Auth::user()->id;
        $id = $request->get('id');
        $cek_order = DB::select("SELECT order_product.order_id, order_product.product_id,
                    sum(order_product.quantity), products.stock, products.Product_name FROM products,order_product 
                    WHERE order_product.product_id = products.id AND order_product.order_id = '$id' 
                    GROUP BY order_product.product_id HAVING SUM(order_product.quantity) > products.stock");
        $count_cek = count($cek_order);
        $stock_status= DB::table('product_stock_status')->first();
        if(($count_cek > 0) && ($stock_status->stock_status == 'ON')){
            return view('errors/error_wa');
        }else{
            if($stock_status->stock_status == 'ON'){
                $cek_quantity = Order::with('products')->where('id',$id)->get();
                foreach($cek_quantity as $q){
                    foreach($q->products as $p){
                        $up_product = product::findOrfail($p->pivot->product_id);
                        $up_product->stock -= $p->pivot->quantity;
                        $up_product->save();
                        }
                    }
            }
            $user = User::findOrfail($user_id);
            $ses_order = $request->session()->get('ses_order');
            $payment_method=$request->get('check_tunai_value');
            if($request->get('notes') != ""){
                $notes=$request->get('notes');
            }else{
                $notes = NULL;
            }
            $customer = Customer::findOrfail($ses_order->customer_id);
            //$city = City::findOrfail($user->city_id);
            $customer_id = $ses_order->customer_id;
            $orders = Order::findOrfail($id);
            $orders->user_loc = $ses_order->user_loc;
            $orders->customer_id = $customer_id;
            $orders->payment_method = $payment_method;
            $orders->notes = $notes;
            
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
            //$total_bayar  = $total_pesanan;

$txt_descwa='*Hello Admin Mega Cools*,

*Detail Sales*
Nama : '.$user->name.',
Email : '.$user->email.',
No. Hp : ' .$user->phone.',
Sales Area : ' .$user->sales_area.',

*Detail Pelanggan*
Nama  : '.$customer->name.',
Email : '.$customer->email.',
No. WA : '.$customer->phone.',
No. Owner : '.$customer->phone_owner.',
No. Toko : '.$customer->phone_store.',
Nama Toko : '.$customer->store_name.',
Alamat : '.$customer->address.',
';

                //$href=urlencode($txt_wa);
                if($orders->save()){
                $groupby_paket = DB::table('order_product')
                                ->where('order_id',$id)
                                ->whereNotNull('paket_id')
                                ->whereNotNull('group_id')
                                ->whereNull('bonus_cat')
                                ->distinct()
                                ->get(['paket_id','group_id']);
                $krj_paket=count($groupby_paket);
                if($krj_paket > 0){
$ttle_pesan_pkt='*Detail Pesanan Paket*
';
$ttle_bns='*Bonus*
';
$no=0;
                    foreach($groupby_paket as $key=>$dtl_pkt){
                        $no++;
                        $paket_name =\App\Paket::where('id',$dtl_pkt->paket_id)
                                    ->first();
                        $group_name =\App\Group::where('id',$dtl_pkt->group_id)
                                    ->first();
                        $ttle_pesan_pkt.= '*_'.$no.'. '.$paket_name->display_name.' - '.$group_name->display_name.':_*
';
                        $data_paket = DB::table('order_product')
                                    ->join('products','order_product.product_id','=','products.id')
                                    ->where('order_id','=',"$id")
                                    ->where('group_id','=',$dtl_pkt->group_id)
                                    ->where('paket_id','=',$dtl_pkt->paket_id)
                                    ->whereNull('bonus_cat')
                                    ->get();
                        foreach($data_paket as $key=>$dp){
                            $ttle_pesan_pkt.='* '.$dp->Product_name.' (Qty :'.$dp->quantity.')
';
                        }

                        $data_bonus = DB::table('order_product')
                                    ->join('orders','order_product.order_id','=','orders.id')
                                    ->join('products','order_product.product_id','=','products.id')
                                    ->where('orders.id','=',"$id")
                                    ->where('group_id','=',$dtl_pkt->group_id)
                                    ->where('paket_id','=',$dtl_pkt->paket_id)
                                    ->whereNotNull('bonus_cat')
                                    ->get();
                        foreach($data_bonus as $db){
                            $ttle_pesan_pkt.= '* '.$db->Product_name.' (Qty :'.$db->quantity.'~ *Bonus*)
';
                        }
                    }
                }
                
                //detil non paket
                $pesan = DB::table('order_product')
                        ->join('orders','order_product.order_id','=','orders.id')
                        ->join('products','order_product.product_id','=','products.id')
                        ->where('orders.id','=',"$id")
                        ->where('group_id','=',NULL)
                        ->where('paket_id','=',NULL)
                        ->get();
                if(count($pesan) > 0){
$ttle_nonpkt='*Detail Pesanan Non Paket*
';
                    foreach($pesan as $key=>$tele){
                        $ttle_nonpkt.='* '.$tele->Product_name.' (Qty :'.$tele->quantity.')
';
                    }
                }
                

                if($request->get('voucher_code_hide_modal')!= ""){
                    if ($type == 1){
                        $info_harga = '*Total Pesanan* : Rp.'.number_format(($sum_novoucher), 0, ',', '.').'%0A*Pembayaran* : '.$payment_method;
                    }else{
                        $info_harga = '*Total Pesanan* : Rp.'.number_format(($sum_novoucher), 0, ',', '.').'%0A*Pembayaran* : '.$payment_method;
                    }
                }
                else{
                    $info_harga = '*Total Pesanan* : Rp.'.number_format(($total_pesanan), 0, ',', '.').'%0A*Pembayaran* : '.$payment_method;
                }
                if($request->get('notes') != ""){
                    $notes_wa=urlencode($request->get('notes'));
                }
                else{
                    $notes_wa = '-';
                } 

                if(($krj_paket > 0) && (count($pesan) > 0)){
                    $list_text = urlencode($txt_descwa).'%0A'.urlencode($ttle_pesan_pkt).'%0A'.urlencode($ttle_nonpkt);
                }
                elseif(($krj_paket > 0) && (count($pesan) <= 0)){
                    $list_text = urlencode($txt_descwa).'%0A'.urlencode($ttle_pesan_pkt);
                }
                else{
                    $list_text = urlencode($txt_descwa).'%0A'.urlencode($ttle_nonpkt);
                }

                $note_sales = '*Notes* : '.$notes_wa;
                $text_wa=$list_text.'%0A'.$info_harga.'%0A'.$note_sales;
            
                $url = "https://api.whatsapp.com/send?phone=6281288222777&text=$text_wa";
                return Redirect::to($url);
                //Alert::success('', 'Pesanan berhasil dikirim');
                //return redirect()->route('home_customer');    
            }
        }
        
        
    }

    public function voucher_code(Request $request){
        $keyword = $request->get('code');
        $vouchers = \App\Voucher::where('code','LIKE BINARY',"%$keyword%")->count();
        if($vouchers > 0 ){
            $vouchers_cek = \App\Voucher::where('code','LIKE BINARY',"%$keyword%")->first();
            if($vouchers_cek->uses < $vouchers_cek->max_uses){
                echo "taken";
            }else{
                echo "full_uses";
            }
            
          }else{
            echo "not_taken";
          }
    }

    public function apply_code(Request $request){
        $keyword = $request->get('code');
        $vouchers = \App\Voucher::where('code','=',"$keyword")->first();
        $ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $session_id = $ses_id.$clientIP;
        $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('session_id','=',"$session_id")
                    ->whereNull('orders.username')
                    ->count();
        if ($total_item < 1){
            echo '<div id="accordion">
                    <div class="card fixed-bottom" style="">
                        <div id="card-cart" class="card-header" >
                            <table width="100%" style="margin-bottom: 40px;">
                                <tbody>
                                    <tr>
                                        <td width="5%" valign="middle">
                                            <div id="ex4">
                                        
                                                <span class="p1 fa-stack fa-2x has-badge" data-count="0">
                                            
                                                    <!--<i class="p2 fa fa-circle fa-stack-2x"></i>-->
                                                    <i class="p3 fa fa-shopping-cart " data-count="4b" style=""></i>
                                                </span>
                                            </div> 
                                        </td>
                                        <td width="25%" align="left" valign="middle">
                                            <h5 id="total_kr_">Rp.0</h5>
                                        </td>
                                        <td width="5%" valign="middle" >
                                        <a id="cv" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="collapsed">
                                                <i class="fas fa-chevron-up" style=""></i>
                                            </a>
                                        </td>
                                        <td width="33%" align="right" valign="middle">
                                        
                                        <h5>(0 Item)</h5>
                                        
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div  class="collapse" data-parent="#accordion" style="" >
                            <div class="card-body" id="card-detail">
                                <div class="col-md-12">
                                <input type="hidden" class="form-control" id="voucher_code_hide" value="">
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        else{
        $keranjang = \App\Order::with('products')
                    ->where('status','=','SUBMIT')
                    ->where('session_id','=',"$session_id")
                    ->whereNull('username')->get();
        $item = DB::table('orders')
                    ->where('session_id','=',"$session_id")
                    ->where('orders.status','=','SUBMIT')
                    ->whereNull('orders.username')
                    ->first();
        $item_name = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('session_id','=',"$session_id")
                    ->whereNotNull('orders.username')
                    ->first();
        $no_disc = DB::table('products')
                    ->join('order_product','products.id','=','order_product.product_id')
                    ->where('order_product.order_id','=',"$item->id")
                    ->where('products.discount','=','0')//->get();
                    ->sum(DB::raw('products.price * order_product.quantity'));
                    //->sum('products.price');
                    //->first();
        $sum_novoucher = $item->total_price;
        //$sum_nodisc = $no_disc->sum('products.price');
        if( $vouchers->type == 1){
           $potongan = ($no_disc * $vouchers->discount_amount) / 100;
            $item_price = $item->total_price - $potongan;
        }
        else if ($vouchers->type == 2)
        {
            $item_price = $item->total_price - $vouchers->discount_amount;
        }
        else
        {
            $item_price = $item->total_price;
        }
        echo 
        '<div id="accordion" class="fixed-bottom">
            <div class="card" style="border-radius:16px;">
                <div id="card-cart" class="card-header" >
                    <table width="100%" style="margin-bottom: 40px;">
                        <tbody>
                            <tr>
                                <td width="5%" valign="middle">
                                    <div id="ex4">
                                
                                        <span id="" class="p1 fa-stack fa-2x has-badge" data-count="'.$total_item.'">
                                    
                                            <!--<i class="p2 fa fa-circle fa-stack-2x"></i>-->
                                            <i class="p3 fa fa-shopping-cart " data-count="4b" style=""></i>
                                        </span>
                                    </div> 
                                </td>
                                <td width="25%" align="left" valign="middle">';
                                    
                                        echo'<h5 id="total_kr_">Rp.&nbsp;'.number_format(($item_price) , 0, ',', '.').'</h5>
                                        <input type="hidden" id="total_kr_val" value="'.$item_price.'">';
                                echo'    
                                </td>
                                <td width="5%" valign="middle" >
                                <a id="cv" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="collapsed">
                                        <i class="fas fa-chevron-up" style=""></i>
                                    </a>
                                </td>
                                <td width="33%" align="right" valign="middle">
                                
                                <h5>('.$total_item.'&nbsp;Item)</h5>
                                
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="collapse-4" class="collapse" data-parent="#accordion" style="" >
                    <div class="card-body" id="card-detail">
                        <div class="col-md-12" style="padding-bottom:7rem;">
                            <table width="100%">
                                <tbody>';
                                    foreach($keranjang as $order){
                                        foreach($order->products as $detil){
                                        echo'<tr>
                                            <td width="25%" valign="middle">
                                                <img src="'.asset('storage/'.(($detil->image!='') ? $detil->image : 'no_image_availabl.png').'').'" 
                                                class="image-detail"  alt="...">   
                                            </td>
                                            <td width="60%" align="left" valign="top">
                                                <p class="name-detail">'.$detil->description.'</p>';
                                                if($detil->discount > 0){
                                                    $total=$detil->price_promo * $detil->pivot->quantity;
                                                }
                                                else{
                                                    $total=$detil->price * $detil->pivot->quantity;
                                                }
                                                echo'<h1 id="productPrice_kr'.$detil->id.'" style="color:#6a3137; !important; font-family: Open Sans;">Rp.&nbsp;'.number_format($total, 0, ',', '.').'</h1>
                                                <table width="10%">
                                                    <tbody>
                                                        <tr id="response-id'.$detil->id.'">
                                                            
                                                            <td width="10px" align="left" valign="middle">
                                                            <input type="hidden" id="order_id'.$detil->id.'" name="order_id" value="'.$order->id.'">';
                                                            if($detil->discount > 0)
                                                            {
                                                                echo'<input type="hidden" id="harga_kr'.$detil->id.'" name="price" value="'.$detil->price_promo.'">';
                                                            }
                                                            else{
                                                                echo'<input type="hidden" id="harga_kr'.$detil->id.'" name="price" value="'.$detil->price.'">';
                                                            }
                                                            echo'<input type="hidden" id="id_detil'.$detil->id.'" value="'.$detil->pivot->id.'">
                                                            <input type="hidden" id="jmlkr_'.$detil->id.'" name="quantity" value="'.$detil->pivot->quantity.'">    
                                                            <button class="button_minus" onclick="button_minus_kr('.$detil->id.')" style="background:none; border:none; color:#693234;outline:none;"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                                                
                                                            </td>
                                                            <td width="10px" align="middle" valign="middle">
                                                                <p id="show_kr_'.$detil->id.'" class="d-inline" style="">'.$detil->pivot->quantity.'</p>
                                                            </td>
                                                            <td width="10px" align="right" valign="middle">
                                                                <button class="button_plus" onclick="button_plus_kr('.$detil->id.')" style="background:none; border:none; color:#693234;outline:none;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                            </td>
                                                        
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td width="15%" align="right" valign="top" style="padding-top: 5%;">
                                                <button class="btn btn-default" onclick="delete_kr('.$detil->id.')" style="">X</button>
                                                <input type="hidden"  id="order_id_delete'.$detil->id.'" name="order_id" value="'.$order->id.'">
                                                <input type="hidden"  id="quantity_delete'.$detil->id.'" name="quantity" value="'.$detil->pivot->quantity.'">';
                                                if($detil->discount > 0)
                                                    {
                                                    echo '<input type="hidden"  id="price_delete'.$detil->id.'" name="price" value="'.$detil->price_promo.'">';
                                                    }
                                                    else{
                                                        echo '<input type="hidden"  id="price_delete'.$detil->id.'" name="price" value="'.$detil->price.'">';
                                                    }
                                                echo'<input type="hidden"  id="product_id_delete'.$detil->id.'"name="product_id" value="'.$detil->id.'">
                                                <input type="hidden" id="id_delete'.$detil->id.'" name="id" value="'.$detil->pivot->id.'">
                                            </td>
                                        </tr>';
                                        
                                        }
                                    }
                                    echo '<tr>
                                        <td align="right" colspan="3">';
                                                
                                        echo'</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <div id="desc_code" style="display:block;">
                                <div class="jumbotron jumbotron-fluid ml-2 py-4 mb-0 px-3">
                                    <p class="lead">Anda mendapatkan potongan harga ';
                                    if($vouchers->type==1){
                                        echo $vouchers->discount_amount; 
                                        echo '%,';
                                    } 
                                    else{
                                        echo 'Rp.'.number_format(($vouchers->discount_amount) , 0, ',', '.').',';
                                    }
                                    echo'<br>'.$vouchers->description.'.</p>
                                </div>
                                <div class="mb-3 mt-1 ml-2">
                                    <a class="btn btn-default" onclick="reset_promo()">Reset Kode Promo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fixed-bottom">
                        <div class="p-3" style="background-color:#e9eff5;border-bottom-right-radius:18px;border-bottom-left-radius:18px;">
                        <input type="hidden" id="order_id_cek" name="id" value="';if($item !== null){echo $item->id;}else{echo '';} echo'"/>';
                            if($item!==null){
                                echo '<input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="'.$item_price.'">
                                <input type="hidden" name="total_pesanan" id="total_pesan_val_code" value="'.$item_price.'">
                                <input type="hidden" name="total_novoucher" id="total_novoucher_val_code" value="'.$sum_novoucher.'">';
                            }
                            else{
                                echo'<input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="0">';
                            }
                            if($total_item > 0){
                            echo'<div class="input-group mb-2 mt-2">
                                    <input type="text" class="form-control" id="voucher_code" 
                                    placeholder="Gunakan Kode Diskon" aria-describedby="basic-addon2" required style="background:#ffcc94;outline:none;">
                                    <div class="input-group-append" required>
                                        <button class="btn " type="submit" onclick="btn_code()" style="background:#6a3137;outline:none;color:white;">Terapkan</button>
                                    </div>
                                </div>';
                            echo '<input type="hidden" class="form-control" id="voucher_code_hide">';    
                            echo '<a type="button" id="beli_sekarang" class="btn btn-block button_add_to_pesan" onclick="show_modal()">Beli Sekarang</a>';
                            }
                        echo'</div>
                    </div>
                </div>
            </div>
        </div>';
        }
    }

    public function ajax_cart(Request $request)
    {   
        /*$ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $session_id = $ses_id.$clientIP;*/
        $id_user = \Auth::user()->id;
        $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('user_id','=',"$id_user")
                    ->whereNull('orders.customer_id')
                    ->distinct('order_product.product_id')
                    /*->whereNull('order_product.group_id')*/
                    ->count();
       /* $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('user_id','=',"$id_user")
                    ->whereNull('orders.customer_id')
                    ->count();*/
        if ($total_item < 1){
            echo '<div id="accordion" class="fixed-bottom" style="border-radius:0;z-index:1;">
                    <div class="card" style="border-radius:0;">
                        <a role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="collapsed">
                        <div id="card-cart" class="card-header pt-1" style="border-radius:0;">
                            <div class="card-cart container">
                                <table class="table borderless">
                                    <tr>
                                        <td align="left" id="td_itm" width="40%">
                                            <h5 style="color:#000">'.$total_item.'&nbsp;Item</h5>
                                        </td>
                                        <td align="middle" id="td_crv" width="20%">
                                            <i class="fas fa-chevron-up" style=""></i>
                                        </td>
                                        <td align="right" id="td_krm-order" width="40%">
                                            <h5 class="pull-right" style="color: #000">Kirim Order&nbsp;&nbsp;<img src="'.asset('assets/image/right-arrow.png').'" width="20" class="my-auto" alt="right-arrow"></h5>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        </a>
                        <div  class="collapse" data-parent="#accordion" style="" >
                            <div class="card-body" id="card-detail">
                                <div class="col-md-12">
                                <input type="hidden" class="form-control" id="voucher_code_hide">
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        else
        {
            $keranjang = \App\Order::with('products_nonpaket')
                        ->where('status','=','SUBMIT')
                        ->where('user_id','=',"$id_user")
                        ->whereNull('customer_id')->get();
            $item = DB::table('orders')
                        ->where('user_id','=',"$id_user")
                        ->where('orders.status','=','SUBMIT')
                        ->whereNull('orders.customer_id')
                        ->first();
            $krj_paket = \App\order_product::where('order_id',$item->id)
                        ->whereNotnull('paket_id')
                        ->whereNotnull('order_id')
                        ->first();
            $item_name = DB::table('orders')
                        ->join('order_product','order_product.order_id','=','orders.id')
                        ->where('user_id','=',"$id_user")
                        ->whereNotNull('orders.customer_id')
                        ->first();
            $item_price = $item->total_price;
        echo 
        '<div id="accordion" class="fixed-bottom" style="border-radius:0;">
            <div class="card" style="border-radius:0;">
                <a role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="collapsed">
                    <div id="card-cart" class="card-header pt-1" style="border-radius:0;">
                        <div class="card-cart container">
                            <table class="table borderless">
                                <tr>
                                    <td align="left" id="td_itm" width="40%">
                                        <h5 style="color:#000">'.$total_item.'&nbsp;Item</h5>
                                    </td>
                                    <td align="middle" id="td_crv" width="20%">
                                        <i class="fas fa-chevron-up" style=""></i>
                                    </td>
                                    <td align="right" id="td_krm-order" width="40%">
                                        <h5 class="pull-right" style="color: #000">Kirim Order&nbsp;&nbsp;<img src="'.asset('assets/image/right-arrow.png').'" width="20" class="my-auto" alt="right-arrow"></h5>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </a>
                <div id="collapse-4" class="collapse" data-parent="#accordion" style="" >
                    <div id="cont-collapse" class="container">
                        <div class="card-body" id="card-detail">
                            <div class="col-md-12" style="padding-bottom:10rem;">';
                            if($krj_paket !=null){
                            echo'<p id="p-title1" class="mb-2" style="font-weight:700;color: #153651;font-family: Montserrat;">Paket</p>
                                <table class="table-detail" width="100%">
                                    <tbody>';
                                            $groupby_paket = \DB::table('order_product')
                                                            ->where('order_id',$item->id)
                                                            ->whereNotNull('paket_id')
                                                            ->whereNotNull('group_id')
                                                            ->whereNull('bonus_cat')
                                                            ->distinct()
                                                            ->get(['paket_id','group_id']);
                                                
                                            foreach($groupby_paket as $dtl_pkt){
                                                    $paket_name =\App\Paket::where('id',$dtl_pkt->paket_id)
                                                                ->first();
                                                    $group_name =\App\Group::where('id',$dtl_pkt->group_id)
                                                                ->first();           
                                                echo'<tr class="pb-0">
                                                    <td width="30%" class="img-detail-cart" valign="top" style="padding-top:3%;">
                                                        <img src="'.asset('storage/'.(($group_name->group_image!='') ? $group_name->group_image : 'no_image_availabl.png').'').'" 
                                                        class="image-detail"  alt="...">
                                                    </td>
                                                    <td width="60%" class="td-desc-detail" align="left" valign="top" style="padding-top:3%;">
                                                        <p style="color: #000">'.$paket_name->display_name.',</p>
                                                        <p style="color: #000">'.$group_name->display_name.'</p>';
                                                            if($item){
                                                            $pkt_total_krj = \App\order_product::where('order_id',$item->id)
                                                            ->where('group_id',$dtl_pkt->group_id)
                                                            ->where('paket_id',$dtl_pkt->paket_id)
                                                            ->whereNull('bonus_cat')
                                                            ->sum('quantity');
                                                            $pkt_pirce = \App\order_product::where('order_id',$item->id)
                                                            ->where('group_id',$dtl_pkt->group_id)
                                                            ->where('paket_id',$dtl_pkt->paket_id)
                                                            ->whereNull('bonus_cat')
                                                            ->sum(\DB::raw('price_item * quantity'));
                                                            }
                                                        
                                                    echo'<h2 style="font-weight:700;color: #153651;font-family: Montserrat;">Rp.&nbsp;'.number_format($pkt_pirce, 0, ',', '.').',-</h2>
                                                        
                                                        <p style="color: #000"><span>Qty</span><span class="d-inline ml-2" style="color: #153651;font-weight:900;">'.$pkt_total_krj.'</span></p>
                                                        <a onclick="open_detail_pkt('.$item->id.','.$dtl_pkt->paket_id.','.$dtl_pkt->group_id.')" style="cursor: pointer"><span class="badge badge-secondary">Detail Paket</span></a>

                                                    </td>
                                                    <td width="15%" align="right" valign="top" style="padding-top:3%;">
                                                    <button class="btn btn-default" onclick="delete_kr_pkt('.$item->id.','.$dtl_pkt->paket_id.','.$dtl_pkt->group_id.')" style="">X</button>
                                                        <input type="hidden"  id="order_id_delete_pkt" name="order_id" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="border-bottom: 1px solid #ddd;">
                                                        <div class="row">
                                                            <div class="col-3 pt-1">
                                                                <p class="" style="font-weight:700;color: #153651;font-family: Montserrat;">Bonus :</p>
                                                            </div>
                                                            <div class="col-9">';
                                                                $groupby_bns = \App\order_product::where('order_id',$item->id)
                                                                                    ->where('paket_id',$dtl_pkt->paket_id)
                                                                                    ->where('group_id',$dtl_pkt->group_id)
                                                                                    ->whereNotNull('bonus_cat')
                                                                                    ->get();
                                                                                    //dd($groupby_bns);
                                                                foreach($groupby_bns as $bns){
                                                                    $prd_bns =\App\product::findOrfail($bns->product_id);
                                                                    
                                                                    echo'<p class="d-none d-md-block d-md-none mt-2" style="color: #000;margin-left:-11rem;">*' .$prd_bns->Product_name.'&nbsp;<span style="color: #153651;">('.$bns->quantity.')</span></p>
                                                                    <p class="d-md-none mt-2 ml-n4" style="color: #000;font-size:3vw;">*'. $prd_bns->Product_name.'&nbsp;<span style="color: #153651;">('.$bns->quantity.')</span></p>';
                                                                    
                                                                }
                                                            echo '</div>
                                                        </div>
                                                    </td>
                                                </tr>';
                                            }
                                        
                                echo'</tbody>
                                </table>';
                            }
                            if(($krj_paket != null) && (count($keranjang) > 0 )){
                                echo '<p id="p-title2" class="mt-4 mb-2" style="font-weight:700;color: #153651;font-family: Montserrat;">Produk Non-Paket</p>';
                            }

                            echo'<table class="table-detail" width="100%">
                                    <tbody>';
                                        foreach($keranjang as $order){
                                            foreach($order->products_nonpaket as $detil){
                                            echo'<tr>
                                                <td width="30%" class="img-detail-cart" valign="middle" style="border-bottom: 1px solid #ddd;padding-top:3%;">
                                                    <img src="'.asset('storage/'.(($detil->image!='') ? $detil->image : 'no_image_availabl.png').'').'" 
                                                    class="image-detail"  alt="...">   
                                                </td>
                                                <td width="60%" class="td-desc-detail" align="left" valign="top" style="border-bottom: 1px solid #ddd;padding-top:3%;">
                                                    <p style="color: #000">'.$detil->Product_name.'</p>';
                                                    if($detil->discount > 0){
                                                        $total=$detil->price_promo * $detil->pivot->quantity;
                                                    }
                                                    else{
                                                        $total=$detil->price * $detil->pivot->quantity;
                                                    }
                                                    echo'<h2 id="productPrice_kr'.$detil->id.'" style="font-weight:700;color: #153651;font-family: Montserrat;">Rp.&nbsp;'.number_format($total, 0, ',', '.').',-</h2>
                                                    <table width="20%" class="tabel-quantity">
                                                        <tbody>
                                                            <tr>
                                                                <td width="3%" align="left" valign="middle" rowspan="2">
                                                                    <p style="color: #000">Qty</p>
                                                                    <input type="hidden" id="order_id'.$detil->id.'" name="order_id" value="'.$order->id.'">';
                                                                    if($detil->discount > 0)
                                                                    {
                                                                        echo'<input type="hidden" id="harga_kr'.$detil->id.'" name="price" value="'.$detil->price_promo.'">';
                                                                    }
                                                                    else{
                                                                        echo'<input type="hidden" id="harga_kr'.$detil->id.'" name="price" value="'.$detil->price.'">';
                                                                    }
                                                                    echo'<input type="hidden" id="id_detil'.$detil->id.'" value="'.$detil->pivot->id.'">
                                                                    <input type="hidden" id="jmlkr_'.$detil->id.'" name="quantity" value="'.$detil->pivot->quantity.'">    
                                                                </td>
                                                                <td width="5%" align="left" valign="middle" rowspan="2">
                                                                    <p id="show_kr_'.$detil->id.'" class="d-inline" style="">'.$detil->pivot->quantity.'</p>
                                                                </td>
                                                                <td width="1%" align="center" valign="middle" bgcolor="#1A4066" style="border-top-left-radius:5px;border-top-right-radius:5px;">
                                                                    <button class="button_plus" onclick="button_plus_kr('.$detil->id.')" style="background:none; border:none; color:#ffffff;outline:none;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="1%" align="middle" valign="middle" bgcolor="#1A4066" style="border-bottom-left-radius:5px;border-bottom-right-radius:5px;">
                                                                    <button class="button_minus" onclick="button_minus_kr('.$detil->id.')" style="background:none; border:none; color:#ffffff;outline:none;"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td width="15%" align="right" valign="top" style="border-bottom: 1px solid #ddd;padding-top: 10%;">
                                                    <button class="btn btn-default" onclick="delete_kr('.$detil->id.')" style="">X</button>
                                                    <input type="hidden"  id="order_id_delete'.$detil->id.'" name="order_id" value="'.$order->id.'">
                                                    <input type="hidden"  id="quantity_delete'.$detil->id.'" name="quantity" value="'.$detil->pivot->quantity.'">';
                                                    if($detil->discount > 0)
                                                        {
                                                        echo '<input type="hidden"  id="price_delete'.$detil->id.'" name="price" value="'.$detil->price_promo.'">';
                                                        }
                                                        else{
                                                            echo '<input type="hidden"  id="price_delete'.$detil->id.'" name="price" value="'.$detil->price.'">';
                                                        }
                                                    echo'<input type="hidden"  id="product_id_delete'.$detil->id.'"name="product_id" value="'.$detil->id.'">
                                                    <input type="hidden" id="id_delete'.$detil->id.'" name="id" value="'.$detil->pivot->id.'">
                                                </td>
                                            </tr>';
                                            
                                            }
                                        }
                                        echo '<tr>
                                            <td align="right" colspan="3">';
                                                    
                                            echo'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            
                                <div id="desc_code" style="display: none;">
                                    <div class="jumbotron jumbotron-fluid ml-2 py-4 mb-3">
                                        <p class="lead"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fixed-bottom" style="background-color:#e9eff5;">
                            <div class="container">
                                <div class="col-md-12 py-3">
                                <input type="hidden" id="order_id_cek" name="id" value="';if($item !== null){echo $item->id;}else{echo '';} echo'"/>';
                                    if($item!==null){
                                        echo '<input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="'.$item_price.'">';
                                    }
                                    else{
                                        echo'<input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="0">';
                                    }
                                    if($total_item > 0){
                                    echo'<!--<div class="input-group mb-2 mt-2">
                                            <input type="text" class="form-control" id="voucher_code" 
                                            placeholder="Gunakan Kode Diskon" aria-describedby="basic-addon2" required style="background:#ffcc94;outline:none;">
                                            <div class="input-group-append" required>
                                                <button class="btn " type="submit" onclick="btn_code()" style="background:#6a3137;outline:none;color:white;">Terapkan</button>
                                            </div>
                                        </div>-->';
                                    echo'
                                        <!--
                                        <div id="divchecktunai" class="custom-control custom-checkbox checkbox-lg ml-n3 mb-4 mt-n2">
                                            <input type="checkbox" class="custom-control-input" id="checktunai" checked="">
                                            <label class="custom-control-label" for="checktunai" style="color: #000;font-weight:600;">Pembayaran Tunai</label>
                                        </div>
                                        -->
                                        <div id="div_total" class="row float-left mt-2">
                                            <p class="mt-1" style="color: #000;font-weight:bold; ">Total Harga</p>&nbsp;
                                            <h2 id="total_kr_" style="font-weight:700;color: #153651;font-family: Montserrat;">Rp.&nbsp;'.number_format(($item_price) , 0, ',', '.').',-</h2>
                                            <input type="hidden" id="total_kr_val" value="'.$item_price.'">  
                                            <input type="hidden" class="form-control" id="voucher_code_hide">
                                        </div>';    
                                    echo'
                                        <div id="chk-bl-btn" class="row justify-content-end my-auto">
                                            <a type="button" id="beli_sekarang" class="btn button_add_to_pesan float-right mb-2" onclick="show_modal()" style="padding: 10px 20px; ">Pesan Sekarang <i class="fab fa-whatsapp" aria-hidden="true" style="color: #ffffff !important; font-weight:900;"></i></a>
                                        </div>';
                                    }
                                echo'</div>
                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>';
        }
    }

    public function cek_order(Request $request){
        $stock_status= DB::table('product_stock_status')->first();
        $order_id = $request->get('order_id');
        if($stock_status->stock_status == 'ON'){
            $cek_order = DB::select("SELECT order_product.order_id, order_product.product_id,
            sum(order_product.quantity), products.stock, products.Product_name FROM products,order_product 
            WHERE order_product.product_id = products.id AND order_product.order_id = '$order_id' 
            GROUP BY order_product.product_id HAVING SUM(order_product.quantity) > products.stock");
        }
        else{
            $cek_order = NULL;
        }
        
        //$count_cek = count($cek_order);
        //return $cek_order;
        // Fetch all records
        $cekData['data'] = $cek_order;
        echo json_encode($cekData);
        exit;
    }

    public function preview_order(Request $request)
    {
        $id = $request->get('order_id');
        $ses_order = $request->session()->get('ses_order');
        $customer = Customer::findOrfail($ses_order->customer_id);
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
        //return view('orders.detail', ['order' => $order, 'paket_list'=>$paket_list]);
        echo'
        <div id="PreviewToko_Produk" style="overflow: hidden;">
            <div class="row px-3">
                <div class="col-md-3 px-0 py-0">
                    <p class="text-left mb-1" style="color: #1A4066 !important;">Nama Toko</p>
                </div>
                <div class="col-md-9 p-0">
                    <div class="panel panel-custom panel-default">
                        <div class="panel-body px-2">
                            <small>
                                <small>
                                <p class="my-2" style="line-height:1.3;color:#000;font-weight:400;text-align:left">
                                    '.$customer->store_name.'
                                </p>
                                </small>
                            </small>
                         </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-0 mt-4">
                <p class="text-left" style="color: #1A4066 !important;">Detail Pesanan</p>
            </div>';
            
            if(count($order->products_nonpaket) > 0){
                echo'
                <table width="100%" class="table table-hover ">
                    <thead style="background: #f0f1f2 !important;text-align:left;">
                        <th class="" width="50%" style="">
                            <small>
                                <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>Produk (NonPaket)</b></p></small>
                            </small>
                        </th>
                        <th width="10%" style="">
                            <div class="d-none d-md-block d-md-none">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>Jumlah</b></p></small>
                                </small>
                            </div>
                            <div class="d-md-none">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>Jml</b></p></small>
                                </small>
                            </div> 
                        </th>
                        <th width="50%" style="text-align:right" class="text-right pl-0">
                            <small>
                                <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Sub Total</b></p></small>
                            </small> 
                        </th>
                    </thead>
                    <tbody>';
                        foreach($order->products_nonpaket as $p){
                        echo'<tr>
                            <td width="50%" style="">
                                <small>
                                    <small><p style="line-height:1.3;color:#000;font-weight:400;text-align:left">'.$p->Product_name.'</p></small>
                                </small>
                            </td>
                            <td style="padding-bottom:0;">
                                <small>
                                    <p style="line-height:1.3;color:#000;font-weight:400;text-align:left">'.$p->pivot->quantity.'</p>
                                </small>
                            </td>
                            <td width="40%" align="right" style="padding-bottom:0;" class="pl-0">';
                                if(($p->pivot->discount_item != NULL) && ($p->pivot->discount_item > 0)){
                                echo '<small><p style="line-height:1.3;color:#000;font-weight:400;text-align:left">Rp. '.number_format($p->pivot->price_item_promo * $p->pivot->quantity, 0, ',', '.').'</p></small>';
                                }else{
                                echo '<p style="line-height:1.3;color:#000;font-weight:400;text-align:right">Rp. '.number_format($p->pivot->price_item * $p->pivot->quantity, 0, ',', '.').'</p></>';
                                }
                            echo'</td>
                        </tr>';
                        }
                        echo '<tr>
                            
                        </tr>
                        <tr>';
                            $pirce_r = \App\order_product::where('order_id',$order->id)
                                ->whereNull('group_id')
                                ->whereNull('paket_id')
                                ->whereNull('bonus_cat')
                                ->sum(\DB::raw('price_item * quantity'));
                            
                            echo'<td colspan="2" align="right">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Total Harga :</b></p></small>
                                </small>
                            </td>
                            <td align="right">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Rp. '.number_format($pirce_r, 0, ',', '.').'</b></p></small>
                                </small>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>';
            }
            
            if(count( $paket_list) > 0){
                foreach($paket_list as $paket){
                    $paket_name =\App\Paket::where('id',$paket->paket_id)
                                    ->first();
                        $group_name =\App\Group::where('id',$paket->group_id)
                                    ->first();           
                    echo '<table width="100%" class="table table-hover">
                        <thead style="background: #f0f1f2 !important;">
                            <th class="" width="50%" style="">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>'.$paket_name->display_name.' - '.$group_name->display_name.'</b></p></small>
                                </small>
                            </th>
                            <th width="10%" style="">
                                <div class="d-none d-md-block d-md-none">
                                    <small>
                                        <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>Jumlah</b></p></small>
                                    </small>
                                </div>
                                <div class="d-md-none">
                                    <small>
                                        <small><p style="line-height:1.2;color:#000;text-align:left;font-weight:400;"><b>Jml</b></p></small>
                                    </small>
                                </div> 
                            </th>
                            <th width="50%" style="text-align:right" class="text-right pl-0">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Sub Total</b></p></small>
                                </small> 
                            </th>
                        </thead>
                        <tbody>';
                                $cek_paket=\DB::table('order_product')
                                            ->join('products','products.id','=','order_product.product_id')
                                            ->where('order_id',$order->id)
                                            ->where('paket_id',$paket->paket_id)
                                            ->where('group_id',$paket->group_id)
                                            ->orderBy('bonus_cat','ASC')
                                            ->get();
                            foreach($cek_paket as $p){
                            echo'<tr>
                                <td width="50%" style="padding-bottom:0;">';
                                    if($p->bonus_cat == NULL){
                                        echo '
                                            <small><p style="line-height:1.3;color:#000;font-weight:400;text-align:left">'.$p->Product_name.'</p></small>
                                       ';
                                    }else{
                                        echo '
                                            <small><p style="line-height:1.3;color:#000;font-weight:400;text-align:left">'.$p->Product_name.'&nbsp;(<small><b>BONUS</b></small>)</p></small>
                                        ';
                                    }
                                echo '</td>
                                <td style="padding-bottom:0;">
                                    
                                        <small><p style="line-height:1.3;color:#000;font-weight:400;text-align:left">'.$p->quantity.'</p></small>
                                    
                                </td>
                                <td align="right" width="50%" style="padding-bottom:0;">';
                                    if($p->bonus_cat == NULL){
                                        if(($p->discount_item != NULL) && ($p->discount_item > 0)){
                                            echo '
                                                <small><p style="line-height:1.3;color:#000;font-weight:400;text-align:left">Rp. '.number_format($p->price_item_promo * $p->quantity, 0, ',', '.').'</p></small>
                                            ';
                                        }else{
                                            echo '<small>
                                                <p style="line-height:1.3;color:#000;font-weight:400;text-align:right">Rp. '.number_format($p->price_item * $p->quantity, 0, ',', '.').'</p>
                                            </small>';
                                        }
                                    }
                                echo '</td>
                            </tr>';
                            }
                            
                            echo '<tr>
                            <td colspan="2" align="right">
                                <small>
                                    <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Total Harga :</b></p></small>
                                </small>
                            </td>';
                                    $pkt_pirce = \App\order_product::where('order_id',$order->id)
                                    ->where('group_id',$paket->group_id)
                                    ->where('paket_id',$paket->paket_id)
                                    ->whereNull('bonus_cat')
                                    ->sum(\DB::raw('price_item * quantity'));
                            echo'<td width="40%" align="right" class="pl-0">
                                    <small>
                                        <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Rp. '.number_format($pkt_pirce, 0, ',', '.').'</b></p></small>
                                    </small>
                                </td>
                            </tr>
                        </tbody>
                    </table>';
                }
            }
            echo '<div style="margin-top:-20px;">
                <table width="100%" class="table table-hover">
                    <thead >
                        <th style="border-bottom:none;" width="62%" class="text-right">
                            <small>
                                <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Grand Total :</b></p></small>
                            </small>
                        </th>
                        <th style="border-bottom:none;" width="" class="text-right pl-0">
                            <small>
                                <small><p style="line-height:1.2;color:#000;text-align:right;font-weight:400;"><b>Rp. '.number_format($order->total_price, 0, ',', '.').'</b></p></small>
                            </small>
                        </th>
                    </thead>
                </table>
            </div>
        </div>';

        
    }

    public function delete_allcart(Request $request)
    {
        $id = $request->get('order_id');
        $order = Order::findorfail($id);
        $order->products()->detach();
        $order->forceDelete();
    }

}
