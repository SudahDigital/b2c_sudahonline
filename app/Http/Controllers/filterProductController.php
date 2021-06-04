<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\product;
use App\order_product;
use App\Order;

class filterProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_user = \Auth::user()->id;
        
        //$session_id = $request->header('User-Agent');
        $banner_active = \App\Banner::orderBy('position', 'ASC')->first();
        $banner = \App\Banner::orderBy('position', 'ASC')->limit(5)->get();
        $category_id = $request->get('id');
        $categories = \App\Category::get();
        $cat_count = $categories->count();
        $top_product = \App\product::with('categories')->where('top_product','=','1')->orderBy('top_product','DESC')->get();
        $product = \App\product::whereHas('categories',function($q) use ($category_id){
                    return $q->where('category_id','=',$category_id);
                    })->get();//->paginate(6);
        $count_data = $product->count();
        $top_count = $top_product->count();
        $keranjang = DB::select("SELECT orders.user_id, orders.status,orders.customer_id, 
                    products.Product_name, products.image, products.price, products.discount,
                    products.price_promo, order_product.id, order_product.order_id,
                    order_product.product_id,order_product.quantity
                    FROM order_product, products, orders WHERE 
                    orders.id = order_product.order_id AND 
                    order_product.product_id = products.id AND orders.status = 'SUBMIT' 
                    AND orders.user_id = '$id_user' AND orders.customer_id IS NULL ");
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
        'banner'=>$banner];

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
