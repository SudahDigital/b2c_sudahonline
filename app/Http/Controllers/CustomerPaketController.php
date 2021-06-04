<?php

namespace App\Http\Controllers;

use App\order_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerPaketController extends Controller
{
    public function index($id){   
        $id_user = \Auth::user()->id;
        $banner_active = \App\Banner::orderBy('position', 'ASC')->first();
        $banner = \App\Banner::orderBy('position', 'ASC')->limit(5)->get();
        $categories = \App\Category::all();//paginate(10);
        $paket = \App\Paket::all()->first();//paginate(10);
        //$paket_id = \App\Paket::findOrfail($id);//paginate(10);
        $cat_count = $categories->count();
        $stock_status= DB::table('product_stock_status')->first();
        $all_product = \App\product::where('status','=','PUBLISH')->get();
        $product = \App\Group::with('item_active')->where('status','ACTIVE')
                    ->get();//->paginate(10);
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
                'all_product'=>$all_product,
                'product'=>$product,
                'item'=>$item,
                'item_name'=>$item_name,
                'count_data'=>$count_data,
                'paket'=>$paket,
                'categories'=>$categories,
                'cat_count'=>$cat_count,
                'banner'=>$banner,
                'banner_active'=>$banner_active,
                //'paket_id'=>$paket_id,
                'stock_status'=>$stock_status
            ];
       
        return view('customer.paket',$data);
             
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
        $group_id=$request->get('group_id');
        //$paket_id=$request->get('paket_id');
        $cek_promo = \App\product::findOrFail($id_product);
        $cek_order = \App\Order::where('user_id','=',"$id_user")
        ->where('status','=','SUBMIT')->whereNull('customer_id')->first();
        if($cek_order !== null){
            $order_product = \App\Order_paket_temp::where('order_id','=',$cek_order->id)
            ->where('product_id','=',$id_product)
            ->whereNull('bonus_cat')->first();
            if($order_product!== null){
                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->quantity = $quantity;
                $order_product->group_id = $group_id;
                //$order_product->paket_id = $paket_id;
                $order_product->save();
                //$cek_order->total_price += $price * $quantity;
                //$cek_order->save();
                return response()->json($cek_order->id);
                }else{
                        $new_order_product = new \App\Order_paket_temp;
                        $new_order_product->order_id =  $cek_order->id;
                        $new_order_product->product_id = $id_product;
                        $new_order_product->price_item = $cek_promo->price;
                        $new_order_product->price_item_promo = $cek_promo->price_promo;
                        $new_order_product->discount_item = $cek_promo->discount;
                        $new_order_product->quantity = $quantity;
                        $new_order_product->group_id = $group_id;
                        //$new_order_product->paket_id = $paket_id;
                        $new_order_product->save();
                        //$cek_order->total_price += $price * $quantity;
                        //$cek_order->save();
                        return response()->json($cek_order->id);
                }
        }
        else{

            $order = new \App\Order;
            $order->user_id = $id_user;
            //$order->quantity = $quantity;
            $order->invoice_number = date('YmdHis');
            //$order->total_price = 0;
            $order->status = 'SUBMIT';
            $order->save();
            if($order->save()){
                $order_product = new \App\Order_paket_temp;
                $order_product->order_id = $order->id;
                $order_product->product_id = $request->get('Product_id');
                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->quantity = $request->get('quantity');
                $order_product->group_id = $group_id;
                //$order_product->paket_id = $paket_id;
                $order_product->save();
                return response()->json($order->id);
            }

        }
        //return response()->json(['return' => 'some data']);    
        //$order->products()->attach($request->get('Product_id'));
        
        return redirect()->back()->with('status','Product berhasil dimasukan kekeranjang');
    }

    public function simpan_bonus(Request $request){ 
        /*$ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $id = $ses_id.$clientIP;*/
        $id_user = \Auth::user()->id; 
        //$id = $request->header('User-Agent'); 
        $id_product = $request->get('Product_id');
        $quantity=$request->get('quantity');
        $price=$request->get('price');
        $group_id=$request->get('group_id');
        $paket_id=$request->get('paket_id');
        $cek_promo = \App\product::findOrFail($id_product);
        $cek_order = \App\Order::where('user_id','=',"$id_user")
        ->where('status','=','SUBMIT')->whereNull('customer_id')->first();
        if($cek_order !== null){
            $order_product = \App\Order_paket_temp::where('order_id','=',$cek_order->id)
            ->where('product_id','=',$id_product)
            ->whereNotNull('bonus_cat')->first();
            if($order_product!== null){
                $order_product->price_item = $cek_promo->price;
                $order_product->price_item_promo = $cek_promo->price_promo;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->quantity = $quantity;
                $order_product->group_id = $group_id;
                $order_product->paket_id = $paket_id;
                //$order_product->bonus_cat = "BONUS";
                $order_product->save();
                //$cek_order->total_price += $price * $quantity;
                //$cek_order->save();
                return response()->json($cek_order->id);
                }else{
                        $new_order_product = new \App\Order_paket_temp;
                        $new_order_product->order_id =  $cek_order->id;
                        $new_order_product->product_id = $id_product;
                        $new_order_product->price_item = $cek_promo->price;
                        $new_order_product->price_item_promo = $cek_promo->price_promo;
                        $new_order_product->discount_item = $cek_promo->discount;
                        $new_order_product->quantity = $quantity;
                        $new_order_product->group_id = $group_id;
                        $new_order_product->paket_id = $paket_id;
                        $new_order_product->bonus_cat = "BONUS";
                        $new_order_product->save();
                        //$cek_order->total_price += $price * $quantity;
                        //$cek_order->save();
                        return response()->json($cek_order->id);
                }
        }
    }

    public function get_total_qty(Request $request){
        $order_id = $request->get('order_id');
        $group_id = $request->get('group_id');
        //$paket_id = $request->get('paket_id');
        $paket = \App\Order_paket_temp::where('order_id',$order_id)
                ->where('group_id',$group_id)
                //->where('paket_id',$paket_id)
                ->whereNull('bonus_cat')
                ->sum('quantity');
        
        //return $total_quantity;
        return response()->json($paket);
        
    }

    public function cek_max_qty(Request $request){
        $total_qty = $request->get('total_qty');
        $max_tmp = \App\Paket::where('status','=','ACTIVE')
                 ->whereRaw("purchase_quantity = (select max(purchase_quantity) FROM pakets WHERE purchase_quantity <= '$total_qty')")
                 ->orderBy('updated_at','DESC')
                 ->first();
        
        $cekData['data'] = $max_tmp;
        echo json_encode($cekData);
        exit;
    }

    public function get_total_qty_bns(Request $request){
        $order_id = $request->get('order_id');
        $group_id = $request->get('group_id');
        $paket_id = $request->get('paket_id');
        $bonus = \App\Order_paket_temp::where('order_id',$order_id)
                ->where('group_id',$group_id)
                ->where('paket_id',$paket_id)
                ->whereNotNull('bonus_cat')
                ->sum('quantity');
        
        //return $total_quantity;
        return response()->json($bonus);
        
    }

    public function delete_paket(Request $request){
        
        $order_id = $request->get('order_id');
        $product_id = $request->get('product_id');
        //$paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        $order_paket = \App\Order_paket_temp::where('order_id','=',$order_id)
                        ->where('product_id','=',$product_id)
                        //->where('paket_id','=',$paket_id)
                        ->where('group_id','=',$group_id)
                        ->whereNull('bonus_cat')->delete();
    }

    public function delete_bonus(Request $request){
        
        $order_id = $request->get('order_id');
        $product_id = $request->get('product_id');
        $paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        $order_bonus = \App\Order_paket_temp::where('order_id','=',$order_id)
                        ->where('product_id','=',$product_id)
                        ->where('paket_id','=',$paket_id)
                        ->where('group_id','=',$group_id)
                        ->whereNotNull('bonus_cat')->delete();
    }

    public function simpan_all_tocart(Request $request){
        $order_id = $request->get('order_id');
        $paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        //$inserts[];
        $paket_tmp = \App\Order_paket_temp::where('order_id',$order_id)
                    //->where('paket_id',$paket_id)
                    ->where('group_id',$group_id)
                    ->get();
        $dateNow = date('Y-m-d H:i:s');
        foreach($paket_tmp as $tmp){
            $cek_harga = \App\product::findOrFail($tmp->product_id);
            $order_product = \App\order_product::where('order_id','=', $tmp->order_id)
                ->where('product_id','=',$tmp->product_id)
                ->where('group_id',$tmp->group_id)
                ->where('paket_id',$paket_id)
                ->where('bonus_cat',$tmp->bonus_cat)->first();
                if($order_product!== null){
                    DB::table('order_product')->where('id', $order_product->id)->update([
                        'order_id' => $tmp->order_id, 
                        'product_id'=>$tmp->product_id,
                        'price_item'=>$cek_harga->price,
                        'price_item_promo'=>$cek_harga->price_promo,
                        'discount_item'=>$cek_harga->discount,
                        'quantity'=>$tmp->quantity + $order_product->quantity,
                        'created_at'=>$tmp->created_at,
                        'updated_at'=>$dateNow,
                        'group_id'=>$tmp->group_id,
                        'paket_id'=>$paket_id,
                        'bonus_cat'=>$tmp->bonus_cat
                    ]);
                }else{
                    DB::table('order_product')->insert([
                        'order_id' => $tmp->order_id, 
                        'product_id'=>$tmp->product_id,
                        'price_item'=>$cek_harga->price,
                        'price_item_promo'=>$cek_harga->price_promo,
                        'discount_item'=>$cek_harga->discount,
                        'quantity'=>$tmp->quantity,
                        'created_at'=>$tmp->created_at,
                        'updated_at'=>$dateNow,
                        'group_id'=>$tmp->group_id,
                        'paket_id'=>$paket_id,
                        'bonus_cat'=>$tmp->bonus_cat
                    ]);
                }
        }
    }

    public function delete_tmp(Request $request){
        $order_id = $request->get('order_id');
        $paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        //$inserts[];
        $paket_tmp = \App\Order_paket_temp::where('order_id',$order_id)
                    //->where('paket_id',$paket_id)
                    ->where('group_id',$group_id)
                    ->delete();
        if($paket_tmp){
            $orders = \App\Order::findOrfail($order_id);
            $order_product = \App\order_product::where('order_id',$order_id)
                            ->where('paket_id',$paket_id)
                            ->where('group_id',$group_id)
                            ->whereNull('bonus_cat')->get();
            $total_price= 0;
            foreach($order_product as $or){
                $price = $or->price_item;
                $total_price += $price * $or->quantity;
            }
            //return $total_price;
            $orders->total_price += $total_price;
            $orders->save();
        }
    }

    public function cek_detail_pkt(Request $request){
        $order_id = $request->get('order_id');
        $paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        $cek_paket = DB::select("SELECT order_product.order_id, order_product.product_id, order_product.price_item, 
                    order_product.quantity, order_product.paket_id, order_product.group_id, order_product.bonus_cat,
                    products.Product_name FROM products,order_product WHERE order_product.product_id = products.id AND 
                    order_product.paket_id ='$paket_id' AND order_product.group_id = '$group_id' AND 
                    order_product.order_id = '$order_id' AND order_product.bonus_cat IS NULL");
        $cekData['data'] = $cek_paket;
        echo json_encode($cekData);
        exit;
    }

    public function delete_kr_pkt(Request $request){
        
        $order_id = $request->get('order_id');
        $paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        $orders = \App\Order::findOrfail($order_id);
        $order_product = \App\order_product::where('order_id',$order_id)
                        ->where('paket_id',$paket_id)
                        ->where('group_id',$group_id)
                        ->whereNull('bonus_cat')->get();
        $total_price= 0;
        foreach($order_product as $or){
            $price = $or->price_item;
            $total_price += $price * $or->quantity;
        }
        $orders->total_price -= $total_price;
        $orders->save();
        if($orders->save()){
            $order_product = \App\order_product::where('order_id',$order_id)
                        ->where('paket_id',$paket_id)
                        ->where('group_id',$group_id)
                        ->delete();
        }
    }

    public function search_paket(Request $request){
        
            $output = '';
            $stock_status= DB::table('product_stock_status')->first();
            $info_stock='';
            $dsbld_btn ='';
            $group_id = $request->get('group_id');
            if($request->get('gr_cat') != ''){
                $gr_cat = $request->get('gr_cat');
            }else{
                $gr_cat = '';
            }
            
            $order_id = $request->get('order_id');
            $query = $request->get('query');
            if($query != '' ){
                if($gr_cat != ''){
                    $product = \App\product::where('status','=','PUBLISH')
                    ->where('Product_name','LIKE',"%$query%")
                    //->orWhere('product_','LIKE',"%$query%")
                    ->get();
                }
                else{
                    $product = DB::select("SELECT * FROM products WHERE Product_name LIKE '%$query%' AND 
                                EXISTS (SELECT group_id,status,product_id FROM group_product WHERE 
                                group_product.product_id = products.id AND status='ACTIVE' AND group_id='$group_id')");
                }
            }
            else{
                if($gr_cat != ''){
                    $product = \App\product::where('status','=','PUBLISH')->get();
                }else{
                    $product = DB::select("SELECT * FROM products WHERE EXISTS 
                                (SELECT group_id,status,product_id FROM group_product WHERE 
                                group_product.product_id = products.id AND status='ACTIVE' AND group_id='$group_id')");
                }
            }
            if($product !== null ){
                $total_row = count($product);
            }
            else{
                $total_row = 0;
            }
            if($total_row > 0){
                foreach($product as $p_group){
                    if($order_id != ''){
                        $qty_on_paket = \App\Order_paket_temp::where('order_id',$order_id)
                                    ->where('product_id',$p_group->id)
                                    //->where('paket_id',$paket_id->id)
                                    ->where('group_id',$group_id)
                                    ->whereNull('bonus_cat')->first();
                        if($qty_on_paket){
                            $harga_on_paket = $p_group->price * $qty_on_paket->quantity; 
                        }
                    }
                    if(($order_id != '') && ($qty_on_paket != NULL)){
                        $c_orderid_delete =  $order_id;
                        $c_check = 'checked';
                        $c_price = $harga_on_paket;
                        $c_jml_val = $qty_on_paket->quantity;
                    }else{
                        $c_orderid_delete = '';
                        $c_check = 'checked disabled';
                        $c_price = $p_group->price;
                        $c_jml_val = 0;
                    }
                    
                    if(($stock_status->stock_status == 'ON')&&($p_group->stock == 0)){
                        $dsbld_btn .= 'disabled';
                        $info_stock.= '<span class="badge badge-warning ">Sisa stok 0</span>';
                    }
                    $output.= '<div id="product_list"  class="col-6 col-md-4 mx-0 d-flex item_pop" style="">
                        <div class="card mx-auto  item_product_pop ">                        
                            <input type="hidden" id="orderid_delete_pkt'.$p_group->id.'_'.$group_id.'" value="'.$c_orderid_delete.'">
                                <div class="round">
                                <input type="checkbox" onclick="delete_pkt('.$p_group->id.','.$group_id.')" id="checkbox_pkt'.$p_group->id.'_'.$group_id.'" '.$c_check.'/>
                                <label for="checkbox_pkt'.$p_group->id.'_'.$group_id.'"></label>
                            </div>
                            <a>
                                <img style="" src="'.asset('storage/'.(($p_group->image!='') ? $p_group->image : 'no_image_availabl.png').'').'" class="img-fluid h-100 w-100 img-responsive" alt="...">
                            </a>
                            
                            <div class="card-body crd-body-pkt d-flex flex-column mt-n3" style="">
                            '.$info_stock.'
                                <div class="float-left px-1 py-2" style="width: 100%;">
                                    <p class="product-price-header_pop mb-0" style="">
                                        '.$p_group->Product_name.'
                                    </p>
                                </div>
                                <div class="float-left px-1 pb-0" style="">
                                    <p style="line-height:1; bottom:0" class="product-price_pop mt-auto" id="productPrice_pkt'.$p_group->id.'_'.$group_id.'" style="">Rp.  '.number_format($c_price, 0, ',', '.') .',-</p> 
                                </div>
                                <div class="justify-content-center input_item_pop mt-auto px-3">
                                    <input type="hidden" id="jumlah_val_pkt'.$p_group->id.'_'.$group_id.'" name="" value="'.$c_jml_val.'">
                                    <input type="hidden" id="jumlah_pkt'.$p_group->id.'_'.$group_id.'" name="quantity_pkt" value="'.$c_jml_val.'">
                                    <input type="hidden" id="harga_pkt'.$p_group->id.'_'.$group_id.'" name="price_pkt" value="'.$p_group->price.'">
                                    <input type="hidden" id="product_pkt'.$p_group->id.'_'.$group_id.'" name="Product_id_pkt" value="'.$p_group->id.'">
                                    <div class="input-group mb-0 mx-auto">
                                        <button class="input-group-text button_minus_pkt" id="button_minus_pkt'.$p_group->id.'_'.$group_id.'" 
                                                style="cursor: pointer;
                                                outline:none;
                                                border:none;
                                                border-top-right-radius:0;
                                                border-bottom-right-radius:0;
                                                border-right-style:none;
                                                font-weight:bold;
                                                padding-right:0;
                                                height:25px" onclick="button_minus_pkt('.$p_group->id.','.$group_id.')" 
                                                onMouseOver="this.style.color=#495057" >-</button>
                                        <input type="number" id="show_pkt'.$p_group->id.'_'.$group_id.'" onkeyup="input_qty_pkt('.$p_group->id.','.$group_id.')" class="form-control show_pkt" value="'.$c_jml_val.'" 
                                                style="background-color:#e9ecef !important;
                                                text-align:center;
                                                border:none;
                                                padding:0;
                                                none !important;
                                                font-weight:bold;
                                                height:25px;
                                                font-size:12px;
                                                font-weight:900;">
                                        <button class="input-group-text" 
                                                style="cursor: pointer;
                                                outline:none;
                                                border:none;
                                                border-top-left-radius:0;
                                                border-bottom-left-radius:0;
                                                border-left-style:none;
                                                font-weight:bold;
                                                padding-left:0;
                                                height:25px" onclick="button_plus_pkt('.$p_group->id.','.$group_id.')">+</button> 
                                    </div>
                                    <button class="btn bt-add-paket btn-block button_add_to_cart respon mt-1" onclick="add_tocart_pkt('.$p_group->id.','.$group_id.')" style="" '.$dsbld_btn.'>Simpan</button> 
                                </div>
                            </div>
                        </div>
                        
                    </div>';
                }
                
            }
            else{
                $output = '<div id="product_list"  class="col-12  mx-0 d-flex item_pop mt-4" style="">
                                <div class="card mx-auto  item_product_pop py-5">
                                    <h5 class="head_pop_prod mb-3 mx-auto" style="">Data tidak ditemukan...</h5>
                                </div>
                            </div>';
            }
            $product = array(
            'table_data'  => $output
            );
         
            echo json_encode($product);
        
    }

    public function search_bonus(Request $request){
        
        $output = '';
        $stock_status= DB::table('product_stock_status')->first();
        $info_stock='';
        $dsbld_btn ='';
        $group_id = $request->get('group_id');
        if($request->get('gr_cat') != ''){
            $gr_cat = $request->get('gr_cat');
        }else{
            $gr_cat = '';
        }
        
        $order_id = $request->get('order_id');
        $query = $request->get('query');
        if($query != '' ){
            if($gr_cat != ''){
                $product = \App\product::where('status','=','PUBLISH')
                ->where('Product_name','LIKE',"%$query%")
                //->orWhere('product_','LIKE',"%$query%")
                ->get();
            }
            else{
                $product = DB::select("SELECT * FROM products WHERE Product_name LIKE '%$query%' AND 
                            EXISTS (SELECT group_id,status,product_id FROM group_product WHERE 
                            group_product.product_id = products.id AND status='ACTIVE' AND group_id='$group_id')");
            }
        }
        else{
            if($gr_cat != ''){
                $product = \App\product::where('status','=','PUBLISH')->get();
            }else{
                $product = DB::select("SELECT * FROM products WHERE EXISTS 
                            (SELECT group_id,status,product_id FROM group_product WHERE 
                            group_product.product_id = products.id AND status='ACTIVE' AND group_id='$group_id')");
            }
        }
        if($product !== null ){
            $total_row = count($product);
        }
        else{
            $total_row = 0;
        }
        if($total_row > 0){
            foreach($product as $p_group){
                if($order_id != ''){
                    $qty_on_bonus = \App\Order_paket_temp::where('order_id',$order_id)
                                    ->where('product_id',$p_group->id)
                                   //->where('paket_id',$paket_id->id)
                                    ->where('group_id',$group_id)
                                    ->whereNotNull('bonus_cat')->first();
                        if($qty_on_bonus){
                            $harga_on_bonus = $p_group->price * $qty_on_bonus->quantity; 
                        }
                }
                if(($order_id != '') && ($qty_on_bonus != NULL)){
                    $c_orderid_delete =  $order_id;
                    $c_check = 'checked';
                    $c_price = $harga_on_bonus;
                    $c_jml_val = $qty_on_bonus->quantity;
                }else{
                    $c_orderid_delete = '';
                    $c_check = 'checked disabled';
                    $c_price = $p_group->price;
                    $c_jml_val = 0;
                }
                if(($stock_status->stock_status == 'ON')&&($p_group->stock == 0)){
                    $dsbld_btn .= 'disabled';
                    $info_stock.= '<span class="badge badge-warning ">Sisa stok 0</span>';
                }
                $output.= '<div class="col-12 col-md-6 d-flex item_pop_bonus pb-4" style="">
                <div class="card card_margin_bonus" style="border-radius: 20px;">
                    <div class="card-horizontal py-0">
                        
                       <input type="hidden" id="orderid_delete_bns'.$p_group->id.'_'.$group_id.' value="'.$c_orderid_delete.'">
                        <div class="round_bns">
                            <input type="checkbox" onclick="delete_bns('.$p_group->id.','.$group_id.')" id="checkbox_bns'.$p_group->id.'_'.$group_id.'" '.$c_check.' style="display:none;"/>
                            <label for="checkbox_bns'.$p_group->id.'_'.$group_id.'"></label>
                        </div>
                        <a>
                            <img src="'.asset('storage/'.(($p_group->image!='') ? $p_group->image : 'no_image_availabl.png').'').'" class="img-fluid img-responsive" alt="..." style="">
                        </a>
                        
                        <div class="card-body d-flex flex-column ml-n4" style="">
                            
                            <div class="float-left pl-0 py-0" style="width: 100%;">
                                <p class="product-price-header_pop mb-0" style="">
                                    '.$p_group->Product_name.'
                                </p>
                            </div>
                            <div class="float-left pl-0 pt-1 pb-0" style="">
                                <p style="line-height:1; bottom:0" class="product-price_pop mt-auto" id="productPrice_bns'.$p_group->id.'_'.$group_id.'" style="">Rp. '.number_format($c_price, 0, ',', '.') .',-</p>
                            </div>
                            '.$info_stock.'
                            <div class="float-left pl-0 mt-auto">
                                <div class="input-group mb-0">
                                    <input type="hidden" id="jumlah_val_bns'.$p_group->id.'_'.$group_id.'" name="" value="'.$c_jml_val.'">
                                    <input type="hidden" id="jumlah_bns'.$p_group->id.'_'.$group_id.'" name="quantity_bns" value="'.$c_jml_val.'">
                                    <input type="hidden" id="harga_bns'.$p_group->id.'_'.$group_id.'" name="price" value="'.$p_group->price.'">
                                    <input type="hidden" id="product_bns'.$p_group->id.'_'.$group_id.'" name="Product_id" value="'.$p_group->id.'">
                                    <button class="input-group-text button_minus_bns" id="button_minus_bns'.$p_group->id.'_'.$group_id.'" 
                                            style="cursor: pointer;
                                            outline:none;
                                            border:none;
                                            border-top-right-radius:0;
                                            border-bottom-right-radius:0;
                                            border-right-style:none;
                                            font-weight:bold;
                                            padding-right:0;
                                            height:25px" onclick="button_minus_bns('.$p_group->id.','.$group_id.')" 
                                            onMouseOver="this.style.color=#495057" >-</button>
                                    <input type="number" id="show_bns'.$p_group->id.'_'.$group_id.'" onkeyup="input_qty_bns('.$p_group->id.','.$group_id.')" class="form-control show_pkt" value="'.$c_jml_val.'" 
                                            style="background-color:#e9ecef !important;
                                            text-align:center;
                                            border:none;
                                            padding:0;
                                            none !important;
                                            font-weight:bold;
                                            height:25px;
                                            font-size:12px;
                                            font-weight:900;">
                                    <button class="input-group-text" 
                                            style="cursor: pointer;
                                            outline:none;
                                            border:none;
                                            border-top-left-radius:0;
                                            border-bottom-left-radius:0;
                                            border-left-style:none;
                                            font-weight:bold;
                                            padding-left:0;
                                            height:25px" onclick="button_plus_bns('.$p_group->id.','.$group_id.')">+</button>
                                </div> 
                            </div>
                            <div class="float-right mt-2">
                                <div id="product_list_bns">
                                    <button class="btn btn-block button_add_to_cart respon" onclick="add_tocart_bns('.$p_group->id.','.$group_id.')" style="" '.$dsbld_btn.'>Simpan</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            }
            
        }
        else{
            $output = '<div id="product_list"  class="col-12  mx-0 d-flex item_pop mt-4" style="">
                            <div class="card mx-auto  item_product_pop py-5">
                                <h5 class="head_pop_prod mb-3 mx-auto" style="">Data tidak ditemukan...</h5>
                            </div>
                        </div>';
        }
        $product = array(
        'table_data'  => $output
        );
     
        echo json_encode($product);
    
    }
}