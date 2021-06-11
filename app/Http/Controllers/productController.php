<?php

namespace App\Http\Controllers;

use App\product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsLowStock;
use App\Exports\AllProductExport;
use App\Imports\ProductsImport;
use Illuminate\Support\Arr;

class productController extends Controller
{
    public function __construct(){
        $this->middleware(function($request, $next){
            
            if(Gate::allows('manage-products')) return $next($request);

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
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$request->client_id'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $status = $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';
        if($status){
        $products = \App\product::with('categories')
        ->where('Product_name','LIKE',"%$keyword%")
        ->where('client_id','=',$clientID)
        ->where('status',strtoupper($status))->get();//->paginate(10);
        }
        else
            {
            $products = \App\product::with('categories')
            ->where('Product_name','LIKE',"%$keyword%")->where('client_id','=',$clientID)->get();
            //->paginate(10);
            }
        return view($clientNM.'.products.index', ['products'=> $products, 'client_slug'=>$clientNM]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        return view($clientNM.'.products.create', ['client_slug'=>$clientNM]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $client)
    {
        /*\Validator::make($request->all(), [
            "Product_name" => "required|min:0|max:200",
            "description" => "required|min:0|max:1000",
            "image" => "required",
            "price" => "required|digits_between:0,10",
            "stock" => "required|digits_between:0,10"
        ])->validate();*/
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $new_product = new \App\product;
        $new_product->Product_name = $request->get('Product_name');
        $new_product->description = $request->get('description');
        if($request->has('discount') && ($request->get('discount') > 0)){
            $new_product->discount = $request->get('discount');
            $percent = $request->get('discount');
            $harga = $request->get('price');
            $discount = ($harga * $percent)/100;
            $harga_discount = $harga - $discount;
            $new_product->price = $harga;
            $new_product->price_promo =  $harga_discount;
        }else{
            $new_product->discount = 0.00;
            $new_product->price = $request->get('price');
            $new_product->price_promo = $request->get('price');
        }
        $new_product->stock = $request->get('stock');
        $new_product->low_stock_treshold = $request->get('low_stock_treshold');
        if($request->has('top_product')){
            $new_product->top_product=$request->get('top_product');
        }else{
            $new_product->top_product = 0;
        }
        $new_product->status = $request->get('save_action');
        $new_product->slug = \Str::slug($request->get('Product_name'));
        $new_product->created_by = \Auth::user()->id;
        $new_product->client_id = $clientID;
        $image = $request->file('image');
      
        if($image){
          $image_path = $image->store('products-images', 'public');
      
          $new_product->image = $image_path;
        }
      
        $new_product->save();

        $new_product->categories()->attach($request->get('categories'));
      
        if($request->get('save_action') == 'PUBLISH'){
          return redirect()
                ->route('products.create', $clientNM)
                ->with('status', 'Product successfully saved and published');
        } else {
          return redirect()
                ->route('Products.create', $clientNM)
                ->with('status', 'Product saved as draft');
        }
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
    public function edit($id, $client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $product = \App\product::where('client_id', $clientID)->findOrFail($id);
        return view($clientNM.'.products.edit', ['product' => $product, 'client_slug' => $clientNM]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $product = \App\product::where('client_id', $clientID)->findOrFail($id);
        $product->Product_name = $request->get('Product_name');
        $product->description = $request->get('description');
        if($request->has('discount') && ($request->get('discount') > 0)){
            $product->discount = $request->get('discount');
            $percent = $request->get('discount');
            $harga = $request->get('price');
            $discount = ($harga * $percent)/100;
            $harga_discount = $harga - $discount;
            $product->price = $harga;
            $product->price_promo = $harga_discount;
        }else{
            $product->price = $request->get('price');
            $product->discount = 0.00;
            $product->price_promo = $request->get('price');
        }
        $product->stock = $request->get('stock');
        $product->low_stock_treshold = $request->get('low_stock_treshold');
        if($request->has('top_product')){
            $product->top_product=$request->get('top_product');
        }else{
            $product->top_product = 0;
        }
        $product->slug = $request->get('slug');
        $new_image = $request->file('image');
        if($new_image){
        if($product->image && file_exists(storage_path('app/public/'.$product->image))){
        \Storage::delete('public/'. $product->image);
        }
        $new_image_path = $new_image->store('products-images', 'public');
        $product->image = $new_image_path;
        }
        $product->updated_by = \Auth::user()->id;
        $product->status = $request->get('status');
        $product->save();
        $product->categories()->sync($request->get('categories'));
        return redirect()->route('products.edit', [$product->id, $clientNM])->with('status',
        'Product successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $client)
    {
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $product = \App\product::where('client_id', $clientID)->findOrFail($id);
        $product->delete();
        return redirect()->route('products.index', $clientNM)->with('status', 'Product moved to
        trash');
    }

    public function trash($client){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $products = \App\product::onlyTrashed()->get();//->paginate(10);

        return view($clientNM.'.products.trash', ['products' => $products, 'client_slug'=>$clientNM]);
    }

    public function restore($id, $client){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $product = \App\product::where('client_id', $clientID)->withTrashed()->findOrFail($id);
        if($product->trashed()){
        $product->restore();
        return redirect()->route('products.trash', $clientNM)->with('status', 'Product successfully restored');
        } else {
        return redirect()->route('products.trash', $clientNM)->with('status', 'Product is not in trash');
        }
    }

    public function deletePermanent($id, $client){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $product = \App\product::where('client_id', $clientID)->withTrashed()->findOrFail($id);
        if(!$product->trashed()){
        return redirect()->route('products.trash', $clientNM)->with('status', 'Product is not in trash!')->with('status_type', 'alert');
        } else {
        $product->categories()->detach();
        $product->forceDelete();
        return redirect()->route('products.trash', $clientNM)->with('status', 'Product permanently deleted!');
        }

    }

    public function low_stock($client){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $products = \App\product::with('categories')->where('client_id', $clientID)->whereRaw('stock < low_stock_treshold')->get();//->paginate(10);

        return view($clientNM.'.products.low_stock', ['products' => $products, 'client_slug'=>$clientNM]);
    }

    public function edit_stock($client){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        return view($clientNM.'.products.edit_stock', ['client_slug'=>$clientNM]);
    }

    public function update_low_stock(Request $request, $client){
        $sql_client = DB::select("SELECT clients.client_id, 
                    clients.client_slug FROM clients 
                    WHERE clients.client_slug = '$client'"); 

        $clientID = $clientNM = "";
        if(count($sql_client) > 0){
            $clientID = $sql_client[0]->client_id;
            $clientNM = $sql_client[0]->client_slug;
        }
        $newstock= $request->get('stock');
        $product = DB::table('products')->whereRaw('stock < low_stock_treshold')
                    ->where('deleted_at',NULL)->where('client_id', $clientID)->update(array('stock' => $newstock));
        return redirect()->back()->with('status',
        'Stock successfully updated');
    }

    public function export_low_stock() {
        return Excel::download( new ProductsLowStock(), 'Products_low_stock.xlsx') ;
    }

    public function export_all() {
        return Excel::download( new AllProductExport(), 'Products.xlsx') ;
    }

    public function import_product(){
        return view('products.import_products');
    }

    public function import_data(Request $request)
    {
        \Validator::make($request->all(), [
            "file" => "required|mimes:xls,xlsx"
        ])->validate();
        
        $data = Excel::toArray(new ProductsImport, request()->file('file')); 

        $update = collect(head($data))
            ->each(function ($row, $key){
                DB::table('products')
                    ->where('id', $row['product_id'])
                    ->update(Arr::except($row,['product_id']));   
            });
        
        if($update){
            return redirect()->route('products.import_products')->with('status', 'File successfully upload'); 
        }
    }
}
