<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\product;
use App\order_product;
use App\Order;



class CustomerKeranjangController extends Controller
{
    
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

        // $tes = \Route::current()->parameter('client_id');
        $ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $session_id = $ses_id.$clientIP;
        $banner_active = \App\Banner::orderBy('id', 'DESC')->first();
        $banner = \App\Banner::orderBy('id', 'DESC')->get();
        $categories = \App\Category::all();//paginate(10);
        $cat_count = $categories->count();
        $top_product = product::with('categories')->where('top_product','=','1')->where('client_id','=',$clientID)->orderBy('top_product','DESC')->get();
        $product = product::with('categories')->where('top_product','=','0')->where('client_id','=',$clientID)->get();//->paginate(6);
        $top_count = $top_product->count();
        $count_data = $product->count();
        $keranjang = DB::select("SELECT orders.session_id, orders.status, orders.username, 
                    products.description, products.image, products.price, products.discount,
                    products.price_promo, order_product.id, order_product.order_id,
                    order_product.product_id,order_product.quantity
                    FROM order_product, products, orders WHERE 
                    orders.id = order_product.order_id AND 
                    order_product.product_id = products.id AND orders.status = 'SUBMIT' 
                    AND orders.session_id = '$session_id' AND orders.username IS NULL
                    AND orders.client_id = '$clientID' ");
        $item = DB::table('orders')
                    ->where('session_id','=',"$session_id")
                    ->where('orders.status','=','SUBMIT')
                    ->whereNull('orders.username')
                    ->where('orders.client_id','=',$clientID)
                    ->first();
        $item_name = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('session_id','=',"$session_id")
                    ->whereNotNull('orders.username')
                    ->where('orders.client_id','=',$clientID)
                    ->first();
        
        $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('session_id','=',"$session_id")
                    ->whereNull('orders.username')
                    ->where('orders.client_id','=',$clientID)
                    ->count();
        $data=['total_item'=> $total_item, 
                'keranjang'=>$keranjang,
                'top_product'=>$top_product,
                'top_count'=>$top_count, 
                'product'=>$product,
                'item'=>$item,
                'item_name'=>$item_name,
                'count_data'=>$count_data,
                'categories'=>$categories,
                'cat_count'=>$cat_count,
                'banner'=>$banner,
                'banner_active'=>$banner_active,
                'client_slug'=>$clientNM];
       return view($clientNM.'.customer.content_customer',$data);
    }
    
    public function simpan(Request $request){ 
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $id = $ses_id.$clientIP; 
        //$id = $request->header('User-Agent'); 
        $id_product = $request->get('Product_id');
        $quantity=$request->get('quantity');
        $price=$request->get('price');
        $cek_promo = product::where('client_id', $clientID)->findOrFail($id_product);
        $cek_order = Order::where('session_id','=',"$id")
        ->where('status','=','SUBMIT')->where('client_id','=',$clientID)->whereNull('username')->first();
        if($cek_order !== null){
            $order_product = order_product::where('order_id','=',$cek_order->id)
            ->where('product_id','=',$id_product)->where('client_id','=',$clientID)->first();
            if($order_product!== null){
                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->quantity += $quantity;
                $order_product->client_id = $clientID;
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
                        $new_order_product->client_id = $clientID;
                        $new_order_product->save();
                        $cek_order->total_price += $price * $quantity;
                        $cek_order->save();
                }
        }
        else{

            $order = new \App\Order;
            $order->session_id = $id;
            //$order->quantity = $quantity;
            $order->invoice_number = date('YmdHis');
            $order->total_price = $price * $quantity;
            $order->status = 'SUBMIT';
            $order->client_id = $clientID;
            $order->save();
            if($order->save()){
                $order_product = new \App\order_product;
                $order_product->order_id = $order->id;
                $order_product->product_id = $request->get('Product_id');
                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->client_id = $clientID;
                $order_product->quantity = $request->get('quantity');
                $order_product->save();
            }

        }
        //return response()->json(['return' => 'some data']);    
        //$order->products()->attach($request->get('Product_id'));
        
        return redirect()->back()->with('status','Product berhasil dimasukan kekeranjang');
    }

    public function min_order(Request $request){ 
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $id = $ses_id.$clientIP; 
        //$id = $request->header('User-Agent'); 
        $id_product = $request->get('Product_id');
        $quantity=$request->get('quantity');
        $price=$request->get('price');
        $cek_promo = product::where('client_id', $clientID)->findOrFail($id_product);
        $cek_order = Order::where('session_id','=',"$id")
        ->where('status','=','SUBMIT')->where('client_id','=',$clientID)->whereNull('username')->first();
        if($cek_order !== null){
            $order_product = order_product::where('order_id','=',$cek_order->id)
            ->where('product_id','=',$id_product)->where('client_id','=',$clientID)->first();
            if(($order_product!== null) AND ($order_product->quantity > 1)){
                $order_product->quantity -= $quantity;
                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->client_id = $clientID;
                $order_product->save();
                $cek_order->total_price -= $price * $quantity;
                $cek_order->save();
                return redirect()->back()->with('status','Product berhasil dikurang dari keranjang');
                }else if(($order_product !== null) and ($order_product->quantity <= 1)){
                        $delete = DB::table('order_product')->where('id', $order_product->id)->where('client_id','=',$clientID)->delete();
                        if($delete){
                            $cek_order_product = order_product::where('order_id','=',$cek_order->id)->where('client_id','=',$clientID)->count();
                            if($cek_order_product < 1){
                                $delete_order = DB::table('orders')->where('id', $cek_order->id)->where('client_id','=',$clientID)->delete();
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
       
    }

    public function tambah(Request $request){
        
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }   
        $id = $request->get('id_detil');
        $order_id = $request->get('order_id');
        $order_product = order_product::where('client_id', $clientID)->findOrFail($id);
        $cek_promo = product::where('client_id', $clientID)->findOrFail($order_product->product_id);
        $order_product->quantity += 1;
        $order_product->price_item = $cek_promo->price;
        $order_product->price_item_promo = $cek_promo->price_promo;
        $order_product->discount_item = $cek_promo->discount;
        $order_product->client_id = $clientID;
        $order_product->save();
        if($order_product->save()){
                $order = Order::where('client_id', $clientID)->findOrFail($order_id);
                $order->total_price += $request->get('price');
                $order->save();
        }
           
            
        //$order->products()->attach($request->get('Product_id'));
        
        return redirect()->back()->with('status','Berhasil menambah produk');
    }

    public function kurang(Request $request){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $id = $request->get('id_detil');
        $order_id = $request->get('order_id');
        $order_product = order_product::where('client_id', $clientID)->findOrFail($id);

        if($order_product->quantity < 2){
            $delete = DB::table('order_product')->where('id', $id)->where('client_id','=',$clientID)->delete();   
            if($delete)
            {   
                $cek_order_product = order_product::where('order_id','=',$order_id)->where('client_id','=',$clientID)->first();
                if($cek_order_product == null){
                    DB::table('orders')->where('id', $order_id)->where('client_id','=',$clientID)->delete();
                }
                else{
                        $order = Order::where('client_id', $clientID)->findOrFail($order_id);
                        $order->total_price -= $request->get('price');
                        $order->client_id = $clientID;
                        $order->save();
                    }
                return redirect()->back()->with('status','Berhasil menghapus produk dari keranjang');
            }
        }
        else{

            $order_product = order_product::where('client_id', $clientID)->findOrFail($id);
            $cek_promo = product::findOrFail($order_product->product_id);
            $order_product->price_item = $cek_promo->price;
            $order_product->price_item_promo = $cek_promo->price_promo;
            $order_product->discount_item = $cek_promo->discount;
            $order_product->quantity -= 1;
            $order_product->client_id = $clientID;
            $order_product->save();
            if($order_product->save()){
                $order = Order::where('client_id', $clientID)->findOrFail($order_id);
                $order->total_price -= $request->get('price');
                $order->client_id = $clientID;
                $order->save();
                return redirect()->back()->with('status','Berhasil mengurangi produk');
            }
        } 
        
    }

    public function delete(Request $request){
        
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }

        $id = $request->get('id');
        $product_id = $request->get('product_id');
        $order_id = $request->get('order_id');
        $quantity = $request->get('quantity');
        $price = $request->get('price');
        $order_product = order_product::where('order_id','=',$order_id)->where('client_id','=',$clientID)->count();
                        if($order_product <= 1){
                        $delete = DB::table('order_product')->where('id', $id)->where('client_id','=',$clientID)->delete();   
                        if($delete){
                            DB::table('orders')->where('id', $order_id)->where('client_id','=',$clientID)->delete();
                            }
                        }
                        else{
                             $delete2 = DB::table('order_product')->where('id', $id)->where('client_id','=',$clientID)->delete();
                             if($delete2){
                                $orders = Order::where('client_id', $clientID)->findOrFail($order_id);
                                $total_price = $price * $quantity;
                                $orders->total_price -= $total_price;
                                $orders->save();
                             }
                        }
                        return redirect()->back()->with('status','Product berhasil dihapus dari keranjang');
    }

    public function pesan(Request $request){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $id = $request->get('id');
        $cek_order = DB::select("SELECT order_product.order_id, order_product.product_id,order_product.quantity, 
                    products.stock, products.description FROM products,order_product WHERE order_product.product_id = products.id AND 
                    order_product.quantity > products.stock AND order_product.order_id = '$id' AND order_product.client_id = '$clientID' AND products.client_id = '$clientID'");
        $count_cek = count($cek_order);
        if($count_cek > 0){
            return view('errors/error_wa');
        }else{
            $cek_quantity = Order::with('products')->where('id',$id)->where('client_id',$clientID)->get();
            foreach($cek_quantity as $q){
                foreach($q->products as $p){
                    $up_product = product::where('client_id', $clientID)->findOrfail($p->pivot->product_id);
                    $up_product->stock -= $p->pivot->quantity;
                    $up_product->save();
                    }
                }
            $username = $request->get('username');
            $email = $request->get('email');
            $address = $request->get('address');
            $phone = $request->get('phone');
            $orders = Order::where('client_id', $clientID)->findOrfail($id);
            $orders->username = $username;
            $orders->email = $email;
            $orders->address = $address;
            $orders->phone = $phone;
            if($request->get('voucher_code_hide_modal') != ""){
                $keyword = $request->get('voucher_code_hide_modal');
                $vouchers_cek = \App\Voucher::where('code','=',"$keyword")->where('client_id','=',$clientID)->first();
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
                $vouchers_cek = \App\Voucher::where('code','=',"$keyword")->where('client_id','=',$clientID)->first();
                $code_name = $vouchers_cek->name;
                $type = $vouchers_cek->type;
                $disc_amount = $vouchers_cek->discount_amount;
                $vouchers = \App\Voucher::where('client_id', $clientID)->findOrFail($vouchers_cek->id);
                $vouchers->uses +=1;
                $vouchers->save();
            }
            $total_ongkir  = 15000;
            $total_bayar  = $total_pesanan + $total_ongkir;
            $href='Hello Admin Gentong,  %0ANama %3A '.$username.', %0AEmail %3A '.$email.', %0ANo. Hp %3A' .$phone.', %0AAlamat %3A' .$address.',%0AIngin membeli %3A%0A';
            if($request->get('voucher_code_hide_modal')!= ""){
                if ($type == 1){
                    $info_harga = 'Total Pesanan %3A Rp.'.number_format(($sum_novoucher), 0, ',', '.').'%0AOngkos Kirim %3A Rp.'.number_format(($total_ongkir), 0, ',', '.').'%0ADiskon %3A '.number_format(($disc_amount), 0, ',', '.').'% %0AJenis Diskon %3A '.$code_name.' %0ATotal Pembayaran %3A Rp.'.number_format(($total_bayar), 0, ',', '.').'%0A';
                }else{
                    $info_harga = 'Total Pesanan %3A Rp.'.number_format(($sum_novoucher), 0, ',', '.').'%0AOngkos Kirim %3A Rp.'.number_format(($total_ongkir), 0, ',', '.').'%0ADiskon %3A Rp.'.number_format(($disc_amount), 0, ',', '.') .'%0AJenis Diskon %3A '.$code_name.' %0ATotal Pembayaran %3A Rp.'.number_format(($total_bayar), 0, ',', '.').'%0A';
                }
            }
            else{
                $info_harga = 'Total Pesanan %3A Rp.'.number_format(($total_pesanan), 0, ',', '.').'%0AOngkos Kirim %3A Rp.'.number_format(($total_ongkir), 0, ',', '.').'%0ATotal Pembayaran %3A Rp.'.number_format(($total_bayar), 0, ',', '.').'%0A';
            }
            if($orders->save()){
                $pesan = DB::table('order_product')
                        ->join('orders','order_product.order_id','=','orders.id')
                        ->join('products','order_product.product_id','=','products.id')
                        ->where('orders.id','=',"$id")
                        ->where('orders.client_id','=',$clientID)
                        ->get();
                foreach($pesan as $key=>$wa){
                    $href.='*'.$wa->description.'%20(Qty %3A%20'.$wa->quantity.' Pcs)%0A';
                }
                $text_wa=$href.'%0A'.$info_harga;
                $sql_wa = DB::table('clients')
                            ->where('client_id','=',$clientID)
                            ->get();
                $no_wa = "";
                foreach($sql_wa as $key=>$wa){
                    $no_wa .= $wa->client_number_wa;
                }
                $number_wa = "62".$no_wa;

                $url = "https://api.whatsapp.com/send?phone=$number_wa&text=$text_wa"; //6282311988000
                return Redirect::to($url);
                
            }
        }
        
        
    }

    public function voucher_code(Request $request){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $keyword = $request->get('code');
        $vouchers = \App\Voucher::where('code','LIKE BINARY',"%$keyword%")->where('client_id','=',$clientID)->count();
        if($vouchers > 0 ){
            $vouchers_cek = \App\Voucher::where('code','LIKE BINARY',"%$keyword%")->where('client_id','=',$clientID)->first();
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
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $keyword = $request->get('code');
        $vouchers = \App\Voucher::where('code','=',"$keyword")->where('client_id','=',$clientID)->first();
        $ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $session_id = $ses_id.$clientIP;
        $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('session_id','=',"$session_id")
                    ->where('orders.client_id','=',$clientID)
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
                    ->where('orders.client_id','=',$clientID)
                    ->whereNull('username')->get();
        $item = DB::table('orders')
                    ->where('session_id','=',"$session_id")
                    ->where('orders.status','=','SUBMIT')
                    ->where('orders.client_id','=',$clientID)
                    ->whereNull('orders.username')
                    ->first();
        $item_name = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('session_id','=',"$session_id")
                    ->where('orders.client_id','=',$clientID)
                    ->whereNotNull('orders.username')
                    ->first();
        $no_disc = DB::table('products')
                    ->join('order_product','products.id','=','order_product.product_id')
                    ->where('order_product.order_id','=',"$item->id")
                    ->where('products.discount','=','0')//->get();
                    ->where('products.client_id','=',$clientID)
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
                                                <img src="'.asset('storage/'.$detil->image).'" 
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
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }

        $ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $session_id = $ses_id.$clientIP;
        $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('session_id','=',"$session_id")
                    ->where('orders.client_id','=',"$clientID")
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
                                <input type="hidden" class="form-control" id="voucher_code_hide">
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        else
        {
            //$session_id = $request->header('User-Agent');
            $keranjang = \App\Order::with('products')
                        ->where('status','=','SUBMIT')
                        ->where('session_id','=',"$session_id")
                        ->where('client_id','=',"$clientID")
                        ->whereNull('username')->get();
            $item = DB::table('orders')
                        ->where('session_id','=',"$session_id")
                        ->where('orders.status','=','SUBMIT')
                        ->where('orders.client_id','=',"$clientID")
                        ->whereNull('orders.username')
                        ->first();
            $item_name = DB::table('orders')
                        ->join('order_product','order_product.order_id','=','orders.id')
                        ->where('session_id','=',"$session_id")
                        ->where('orders.client_id','=',"$clientID")
                        ->whereNotNull('orders.username')
                        ->first();
            $item_price = $item->total_price;
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
                        <div class="col-md-12" style="padding-bottom:6rem;">
                            <table width="100%">
                                <tbody>';
                                    foreach($keranjang as $order){
                                        foreach($order->products as $detil){
                                        echo'<tr>
                                            <td width="25%" valign="middle">
                                                <img src="'.asset('storage/'.$detil->image).'" 
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
                            <div id="desc_code" style="display: none;">
                                <div class="jumbotron jumbotron-fluid ml-2 py-4 mb-3">
                                    <p class="lead"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fixed-bottom">
                        <div class="p-3" style="background-color:#e9eff5;border-bottom-right-radius:18px;border-bottom-left-radius:18px;">
                        <input type="hidden" id="order_id_cek" name="id" value="';if($item !== null){echo $item->id;}else{echo '';} echo'"/>';
                            if($item!==null){
                                echo '<input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="'.$item_price.'">';
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

    public function cek_order(Request $request){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $order_id = $request->get('order_id');
        $cek_order = DB::select("SELECT order_product.order_id, order_product.product_id,order_product.quantity, 
                    products.stock, products.description FROM products,order_product WHERE order_product.product_id = products.id AND 
                    order_product.quantity > products.stock AND order_product.order_id = '$order_id' AND order_product.client_id = '$clientID'");
        //$count_cek = count($cek_order);
        //return $cek_order;
        // Fetch all records
        $cekData['data'] = $cek_order;
        echo json_encode($cekData);
        exit;
    }

}
