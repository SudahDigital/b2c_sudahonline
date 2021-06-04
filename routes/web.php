<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', 'WelcomeController@index');
Route::get('/product/detail/', 'ProductDetailController@detail')->name('product_detail');
//Sales route
Route::group(['middleware' => ['auth','checkRole:SALES']],function(){
    Route::get('/contact', function(){
        $categories = \App\Category::get();
        $paket = \App\Paket::all()->first();//paginate(10);	
        return view('customer.contact',['categories'=>$categories,'paket'=>$paket]);
        })->name('contact');        
    Route::get('/sales_home/{cat?}', 'CustomerKeranjangController@index')->name('home_customer');
    Route::get('/sales_home/{paket}/paket', 'CustomerPaketController@index')->name('home_paket');
    //Route::get('/sales_home/paket_group', 'CustomerPaketController@index')->name('home_paket');
    Route::get('/ajax/city', 'AjaxCitySearch@ajax_city');
    Route::post('/ajax/store', 'AjaxCitySearch@ajax_store');
    Route::post('/session/store','SessionStore@index')->name('session.store');
    Route::post('/session/new/store','SessionStore@new_store')->name('session.new_store');
    Route::get('/session/clear','SessionStore@clear')->name('session.clear');
    Route::resource('profil','ProfilController');
    Route::get('/home_cart', 'CustomerKeranjangController@ajax_cart');
    Route::post('/keranjang/apply_code', 'CustomerKeranjangController@apply_code');
    Route::post('/keranjang/simpan','CustomerKeranjangController@simpan')->name('customer.keranjang.simpan');
    Route::post('/keranjang/min_order','CustomerKeranjangController@min_order')->name('customer.keranjang.min_order');
    Route::post('/keranjang/tambah','CustomerKeranjangController@tambah')->name('customer.keranjang.tambah');
    Route::post('/keranjang/kurang','CustomerKeranjangController@kurang')->name('customer.keranjang.kurang');
    Route::post('/keranjang/delete','CustomerKeranjangController@delete')->name('customer.keranjang.delete');
    Route::post('/keranjang/search_vcode','CustomerKeranjangController@voucher_code')->name('customer.keranjang.vcode');
    Route::post('/keranjang/pesan','CustomerKeranjangController@pesan')->name('customer.keranjang.pesan');
    Route::post('/keranjang/delete_allcart','CustomerKeranjangController@delete_allcart');
    Route::post('/keranjang/cek_order','CustomerKeranjangController@cek_order');
    Route::post('/preview_order','CustomerKeranjangController@preview_order');
    //Route::get('/histori','historiController@index')->name('riwayat_pemesanan');
    //Route::resource('category','filterProductController');
    Route::resource('search','searchController');
    Route::get('/updated-activity', 'TelegramBotController@updatedActivity')->name('update.telegram');
    Route::post('/keranjang/paket/simpan','CustomerPaketController@simpan')->name('customer.paket.simpan');
    Route::post('/keranjang/paket/totalquantity','CustomerPaketController@get_total_qty');
    Route::post('/keranjang/paket/cek_max_qty','CustomerPaketController@cek_max_qty');
    Route::post('/keranjang/paket/delete_pkt','CustomerPaketController@delete_paket');
    Route::post('/keranjang/bonus/simpan','CustomerPaketController@simpan_bonus');
    Route::post('/keranjang/bonus/totalquantity','CustomerPaketController@get_total_qty_bns');
    Route::post('/keranjang/bonus/delete_bns','CustomerPaketController@delete_bonus');
    Route::post('/keranjang/paket_all/simpan_cart','CustomerPaketController@simpan_all_tocart');
    Route::post('/keranjang/paket_all/delete_tmp','CustomerPaketController@delete_tmp');
    Route::post('/keranjang/cek_detail/paket','CustomerPaketController@cek_detail_pkt');
    Route::post('/keranjang/delete_kr/paket','CustomerPaketController@delete_kr_pkt');
    Route::post('/paket/product_search','CustomerPaketController@search_paket');
    Route::post('/bonus/product_search','CustomerPaketController@search_bonus');
    Route::get('/pesanan/{status?}','TransaksiSalesController@index')->name('pesanan');
    Route::post('/pesanan/detail','TransaksiSalesController@detail');
    Route::post('/sales/order_search','TransaksiSalesController@search_order');
});

Route::match(["GET", "POST"], "/register", function(){
    return redirect("/login");
})->name("register");

Route::get('/admin', function () {
    $categories = \App\Category::get();
    return view('auth.login',['categories'=>$categories]);
    });

//Admin Route
    
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::group(['prefix' => '/{vendor}'], function()  
    {  
        Route::get('/admin', 'HomeController@home_admin')->name('home_admin');
        
    });
        Route::resource('users','UserController');
        Route::get('/users/change_password', 'changePasswordController@index')->name('changepass');
        Route::post('/users/post/change_password', 'changePasswordController@changepassword')->name('post.changepass');
        
    
    Route::get('/ajax/cities/search', 'SalesController@ajaxSearch');
    Route::get('/sales/export', 'SalesController@export')->name('sales.export');
    Route::resource('sales','SalesController');
    Route::resource('spv','SpvController');
    Route::post('/ajax/post-sortable','BannerController@post_sortable');
    Route::get('/banner/trash', 'BannerController@trash')->name('banner.trash');
    Route::get('/banner/{id}/restore', 'BannerController@restore')->name('banner.restore');
    Route::delete('/banner/{banner}/delete-permanent','BannerController@deletePermanent')->name('banner.delete-permanent');
    Route::resource('banner','BannerController');
    Route::get('/categories/export', 'CategoryController@export')->name('categories.export');
    Route::get('/categories/trash', 'CategoryController@trash')->name('categories.trash');
    Route::get('/categories/{id}/restore', 'CategoryController@restore')->name('categories.restore');
    Route::delete('/categories/{category}/delete-permanent','CategoryController@deletePermanent')->name('categories.delete-permanent');
    Route::resource('categories','CategoryController');
    Route::get('/ajax/categories/search', 'CategoryController@ajaxSearch');
    Route::get('/ajax/products/code/search', 'productController@codeSearch');
    Route::get('/products/change_status_stock', 'productController@OnOff_stock');
    Route::get('/products/export_all', 'productController@export_all')->name('products.export_all');
    Route::get('/products/export_lowstock', 'productController@export_low_stock')->name('products.export_lowstock');
    Route::post('/products/update_lowstock', 'productController@update_low_stock')->name('products.update_lowstock');
    Route::post('/products/import_data', 'productController@import_data')->name('products.import_data');
    Route::get('/products/low_stock', 'productController@low_stock')->name('products.low_stock');
    Route::get('/products/import_products', 'productController@import_product')->name('products.import_products');
    Route::get('/products/edit_stock', 'productController@edit_stock')->name('products.edit_stock');
    Route::get('/products/trash', 'productController@trash')->name('products.trash');
    Route::get('/products/{id}/restore', 'productController@restore')->name('products.restore');
    Route::delete('/products/{products}/delete-permanent','productController@deletePermanent')->name('products.delete-permanent');
    Route::resource('products', 'productController');
    Route::get('orders/export_mapping', 'OrderController@export_mapping')->name('orders.export_mapping') ;
    Route::get('/orders/{id}/edit_order', 'OrderEditController@edit')->name('order_edit');
    Route::post('/orders/edit_order_update', 'OrderEditController@update')->name('order_edit_update');
    Route::get('/orders/{id}/detail', 'OrderController@detail')->name('orders.detail');
    Route::resource('orders', 'OrderController');
    Route::get('/ajax/vouchers/search', 'VoucherController@ajaxSearch');
    Route::get('/vouchers/trash', 'VoucherController@trash')->name('vouchers.trash');
    Route::get('/vouchers/{id}/restore', 'voucherController@restore')->name('vouchers.restore');
    Route::delete('/vouchers/{vouchers}/delete-permanent','voucherController@deletePermanent')->name('vouchers.delete-permanent');
    Route::resource('vouchers','VoucherController');
    Route::delete('/customers/{customers}/delete-permanent','CustomerController@deletePermanent')->name('customers.delete-permanent');
    Route::get('/customers/{id}/detail', 'CustomerController@detail')->name('customers.detail');
    Route::get('/customers/export', 'CustomerController@export')->name('customers.export');
    Route::get('/customers/export_city', 'CustomerController@exportCity')->name('cities.export');
    Route::get('/customers/import', 'CustomerController@import')->name('customers.import');
    Route::post('/customers/import_data', 'CustomerController@import_data')->name('customers.import_data');
    Route::get('/ajax/code_cust/search', 'CustomerController@ajaxSearch');
    Route::get('/ajax/users/search', 'CustomerController@ajaxUserSearch');
    Route::get('/customer/ajax/city_search', 'CustomerController@ajaxCitySearch');
    Route::resource('customers','CustomerController');
    //Route::get('/ajax/groups/search', 'GroupController@ajaxSearch');
    Route::get('/ajax/groups/search', 'GroupController@GroupNameSearch');
    //Route::post('/groups/add/item', 'GroupController@add_item')->name('groups.add_item');
    Route::post('/groups/edit_status', 'GroupController@update_status')->name('groups.edit_status');
    //Route::get('/groups/{id}/{status}/edit_status', 'GroupController@update_status')->name('groups.update_status');
    Route::resource('groups','GroupController');
    Route::get('/ajax/paket/search', 'PaketController@PaketNameSearch');
    Route::post('/paket/edit_status', 'PaketController@update_status')->name('paket.edit_status');
    Route::resource('paket','PaketController');



    

