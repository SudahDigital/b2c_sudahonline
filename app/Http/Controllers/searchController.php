<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class searchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $client = \Route::current()->parameter('client_id');
            $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

            $clientID = $clientNM = "";
            if(count($sql_client) > 0){
                $clientID = $sql_client[0]->client_id;
                $clientNM = $sql_client[0]->client_slug;
            }
            $ses_id = $request->header('User-Agent');
            $clientIP = \Request::getClientIp(true);
            $session_id = $ses_id.$clientIP;
            //$session_id = $request->header('User-Agent');
            $banner_active = \App\Banner::orderBy('id', 'DESC')->first();
            $banner = \App\Banner::orderBy('id', 'DESC')->get();
            $keyword = $request->get('keyword') ? $request->get('keyword') : '';
            $categories = \App\Category::get();
            $cat_count = $categories->count();
            $top_product = \App\product::with('categories')->where('top_product','=','1')->where('client_id','=',$clientID)->orderBy('top_product','DESC')->get();
            $product = \App\product::with('categories')->where("description", "LIKE", "%$keyword%")->where('client_id','=',$clientID)->paginate(6);
            $count_data = $product->count();
            $top_count = $top_product->count();
            $keranjang = DB::select("SELECT orders.session_id, orders.status, orders.username, 
                        products.description, products.image, products.price, products.discount,
                        products.price_promo, order_product.id, order_product.order_id,
                        order_product.product_id,order_product.quantity
                        FROM order_product, products, orders WHERE 
                        orders.id = order_product.order_id AND 
                        order_product.product_id = products.id AND orders.status = 'SUBMIT' 
                        AND orders.session_id = '$session_id' AND orders.username IS NULL");
            $item = DB::table('orders')
                        ->where('session_id','=',"$session_id")
                        ->where('orders.status','=','SUBMIT')
                        ->whereNull('username')
                        ->where('orders.client_id','=',$clientID)
                        ->first();
            $item_name = DB::table('orders')
                        ->join('order_product','order_product.order_id','=','orders.id')
                        ->where('session_id','=',"$session_id")
                        ->whereNull('username')
                        ->where('orders.client_id','=',$clientID)
                        ->first();
            
            $total_item = DB::table('orders')
                        ->join('order_product','order_product.order_id','=','orders.id')
                        ->where('session_id','=',"$session_id")
                        ->whereNull('username')
                        ->where('orders.client_id','=',$clientID)
                    ->count();
            $data=['total_item'=> $total_item, 
            'keranjang'=>$keranjang, 
            'product'=>$product,
            'top_product'=>$top_product,
            'top_count'=>$top_count,
            'item'=>$item,
            'item_name'=>$item_name,
            'count_data'=>$count_data,
            'categories'=>$categories,
            'cat_count'=>$cat_count,
            'banner_active'=>$banner_active,
            'banner'=>$banner,
            'client_slug'=>$clientNM];
       
        // return view($clientNM.'.customer.content_customer',$data);
            return view('customer.content_customer',$data);

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
        //
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
}
