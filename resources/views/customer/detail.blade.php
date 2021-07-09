@extends('customer.layouts.template-nobanner')
@section('content')

    <div class="container" style="margin-top: 80px;">
        <div class="row align-middle">
            <div class="col-sm-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-0 button_breadcrumb">
                        <li class="breadcrumb-item" style="color: #6a3137 !important;margin-top:30px; margin-left:30px;"><a href="{{Auth::user() ? url('/home_customer') : url('/') }}"><i class="fa fa-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="margin-top:30px;">Detail Produk</li>
                    </ol>
                </nav>
            </div>
        </div>
    
        <div class="row section_content">
            <div class="col-sm-12 col-md-6 mb-0" >
                <div class="card mx-auto item_product mb-3">
                    @if($product->discount > 0)
                        <div class="ribbon"><span class="span-ribbon">{{$product->discount}}% OFF</span></div>
                    @endif
                    <img style="width:100%; height:auto;" src="{{ asset('storage/'.(($product->image!='') ? $product->image : '20200621_184223_0016.jpg').'') }}" class="card-img-top img-fluid mb-0" alt="...">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-0">
                <div class="card mx-auto item_product">
                    <div class="card-body m-0 p-4">
                        <div class="float-left py-2" style="width: 100%;">
                            <h4 class="" style="color:#6a3137 !important; font-weight:900;">{{$product->Product_name}}</h4>
                            <hr style="border-top:1px solid #6a3137;">
                            <p class="product-price-header mb-0" style="">
                                {{$product->description}}
                            </p>
                        </div>
                        <div>
                            @if($product->discount > 0)
                            <div class="float-left py-2" style="width: 100%;">
                            <p class="product-price-header mb-0" style="">
                                <del><b><i>Rp. {{ number_format($product->price, 0, ',', '.') }}</i></b> </del>
                            </p>
                            </div>
                            <div class="float-left  mb-3" style="">
                                <p style="line-height: 1;" class="product-price mb-0 " id="productPrice{{$product->id}}" >Rp. {{ number_format($product->price_promo, 0, ',', '.') }}</p>
                            </div>
                            @else
                            <div class="float-left mb-3">
                                <p style="line-height: 1;" class="product-price mb-0 " id="productPrice{{$product->id}}" >Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            @endif
                            
                            <table width="100%" class="hdr_tbl_cart" >
                                <tbody>
                                <tr><!--
                                    <td class="tbl_cart" valign="middle" style="">
                                    </td>-->
                                    <!--<button class="btn btn-block button_add_to_cart respon" style="">Tambah</button>-->
                                    <td width="10%" align="right" valign="middle">
                                        <input type="hidden" id="Product_id{{$product->id}}" name="Product_id" value="{{$product->id}}">
                                        <input type="hidden" id="quantity_add{{$product->id}}" name="quantity" value="1">
                                        @if($product->discount > 0)
                                        <input type="hidden" id="harga{{$product->id}}" name="price" value="{{$product->price_promo}}">
                                        @else
                                        <input type="hidden" id="harga{{$product->id}}" name="price" value="{{$product->price}}">
                                        @endif
                                        @if($product->stock > 0)
                                        <button class="btn button_minus" onclick="button_minus('{{$product->id}}')" style="background:none; border:none; color:#693234;outline:none;"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                        @else
                                        <button disabled class="btn button_minus" onclick="" style="background:none; border:none; color:#693234;outline:none;cursor:no-drop;"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                        @endif
                                    </td>
                                    <td width="1%" align="center" valign="middle">
                                        <?php
                                        $ses_id = \Request::header('User-Agent');
                                        $clientIP = \Request::getClientIp(true);
                                        $user = $ses_id.$clientIP;  
                                        //$user = \Request::header('User-Agent'); 
                                        $view_pesan = \DB::select("SELECT orders.session_id, orders.status, orders.username, 
                                                    products.description, products.image, products.price, order_product.id,
                                                    order_product.order_id,order_product.product_id,order_product.quantity
                                                    FROM order_product, products, orders WHERE 
                                                    orders.id = order_product.order_id AND order_product.product_id = $product->id AND 
                                                    order_product.product_id = products.id AND orders.status = 'SUBMIT' 
                                                    AND orders.session_id = '$user' AND orders.username IS NULL ");
                                        $hitung = count($view_pesan);
                                            if($hitung > 0){
                                                foreach ($view_pesan as $key => $k) {
                                                echo '<p id="show_'.$product->id.'" class="d-inline show" style="">'.$k->quantity.'</p>';
                                                echo '<input type="hidden" id="jmlbrg_'.$product->id.'" name="quantity" value="'.$k->quantity.'">';
                                                }
                                            }
                                            else{
                                                echo '<input type="hidden" id="jmlbrg_'.$product->id.'" name="quantity" value="0">';
                                                echo '<p id="show_'.$product->id.'" class="d-inline show" style="">0</p>';
                                            }
                                        ?>
                                        <input type="hidden" id="stock{{$product->id}}" name="stock" value="{{$product->stock}}">
                                    </td>
                                    <td width="10%" align="left" valign="middle">
                                        @if($product->stock > 0)
                                        <button class="btn button_plus" onclick="button_plus('{{$product->id}}')" style="background:none; border:none; color:#693234;outline:none;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        @else
                                        <button disabled class="btn button_plus" onclick="" style="background:none; border:none; color:#693234;outline:none;cursor: no-drop;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            @if($product->stock == 0)
                                <div class="p-1 mb-0 text-dark text-center" style="border-radius:7px;background-color:#e9eff5;"><small><b>Sisa Stok {{$product->stock}}</b></small></div>
                            @endif       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <br><br><br>

    <div id="accordion" class="fixed-bottom">
        <div class="card" style="border-radius:16px;">
            <div id="card-cart" class="card-header" >
                <table width="100%" style="margin-bottom: 40px;">
                    <tbody>
                        <tr>
                            <td width="5%" valign="middle">
                                <div id="ex4">
                                
                                    <span class="p1 fa-stack fa-2x has-badge" data-count="{{$total_item}}">
                                
                                        <!--<i class="p2 fa fa-circle fa-stack-2x"></i>-->
                                        <i class="p3 fa fa-shopping-cart " data-count="4b" style=""></i>
                                    </span>
                                </div> 
                            </td>
                            <td width="25%" align="left" valign="middle">
                                @if($item!==null)
                            <h5 id="total_kr_"> Rp. {{number_format($item->total_price , 0, ',', '.')}}</h5>
                            <input type="hidden" id="total_kr_val" value="{{$item->total_price}}">
                                @else
                            <h5 id="total_kr_"> Rp. 0</h5>
                            <input type="hidden" id="total_kr_val" value="0">
                                @endif
                            </td>
                            <td width="5%" valign="middle" >
                            <a id="cv" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="collapsed">
                                    <i class="fas fa-chevron-up" style=""></i>
                                </a>
                            </td>
                            <td width="33%" align="right" valign="middle">
                                
                            <h5>({{$total_item}} Item)</h5>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="{{$total_item > 0 ? 'collapse-4' : '' }}" class="collapse" data-parent="#accordion" style="" >
                <div class="card-body" id="card-detail">
                    <div class="col-md-12" style="padding-bottom:6rem;">
                        <table width="100%">
                            <tbody>
                                @foreach($keranjang as $detil)
                                <tr>
                                    <td width="25%" valign="middle">
                                        <img src="{{ asset('storage/'.$detil->image)}}" 
                                        class="image-detail"  alt="...">   
                                    </td>
                                    <td width="60%" align="left" valign="top">
                                        <p class="name-detail">{{ $detil->description}}</p>
                                        <?php
                                        if($detil->discount > 0){
                                            $total = $detil->price_promo * $detil->quantity;
                                        }else{
                                            $total=$detil->price * $detil->quantity;
                                        } 
                                        ?>
                                        <h1 id="productPrice_kr{{$detil->product_id}}" style="color:#6a3137; !important; font-family: Open Sans;">Rp {{ number_format($total, 0, ',', '.') }}</h1>
                                        <table width="10%">
                                            <tbody>
                                                <tr>
                                                    
                                                    <td width="10px" align="left" valign="middle">
                                                            <input type="hidden" id="order_id{{$detil->product_id}}" name="order_id" value="{{$detil->order_id}}">
                                                            @if($detil->discount > 0)
                                                            <input type="hidden" id="harga_kr{{$detil->product_id}}" name="price" value="{{$detil->price_promo}}">
                                                            @else
                                                            <input type="hidden" id="harga_kr{{$detil->product_id}}" name="price" value="{{$detil->price}}">
                                                            @endif
                                                            <input type="hidden" id="id_detil{{$detil->product_id}}" value="{{$detil->id}}">
                                                            <input type="hidden" id="jmlkr_{{$detil->product_id}}" name="quantity" value="{{$detil->quantity}}">    
                                                            <button class="button_minus" onclick="button_minus_kr('{{$detil->product_id}}')" style="background:none; border:none; color:#693234;outline:none;"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                                        
                                                    </td>
                                                    <td width="10px" align="middle" valign="middle">
                                                        <p id="show_kr_{{$detil->product_id}}" class="d-inline" style="">{{$detil->quantity}}</p>
                                                    </td>
                                                    <td width="10px" align="right" valign="middle">
                                                        <button class="button_plus" onclick="button_plus_kr('{{$detil->product_id}}')" style="background:none; border:none; color:#693234;outline:none;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                    </td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td width="15%" align="right" valign="top" style="padding-top: 5%;">
                                        <button class="btn btn-default" onclick="delete_kr('{{$detil->product_id}}')" style="">X</button>
                                        <input type="hidden"  id="order_id_delete{{$detil->product_id}}" name="order_id" value="{{$detil->order_id}}">
                                        <input type="hidden"  id="quantity_delete{{$detil->product_id}}" name="quantity" value="{{$detil->quantity}}">
                                        @if($detil->discount > 0)
                                        <input type="hidden"  id="price_delete{{$detil->product_id}}" name="price" value="{{$detil->price_promo}}">
                                        @else
                                        <input type="hidden"  id="price_delete{{$detil->product_id}}" name="price" value="{{$detil->price}}">
                                        @endif
                                        <input type="hidden"  id="product_id_delete{{$detil->product_id}}"name="product_id" value="{{$detil->product_id}}">
                                        <input type="hidden" id="id_delete{{$detil->product_id}}" name="id" value="{{$detil->id}}">
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td align="right" colspan="3">
                                        
                                    </td>
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
                        <input type="hidden" class="form-control" id="voucher_code_hide">
                        @if($total_item > 0)
                        <div class="input-group mb-2 mt-2">
                            <input type="text" class="form-control" id="voucher_code" 
                            placeholder="Gunakan Kode Diskon" aria-describedby="basic-addon2" required style="background:#ffcc94;outline:none;">
                            <div class="input-group-append" required>
                                <button class="btn " type="submit" onclick="btn_code('')" style="background:#6a3137;outline:none;color:white;">Terapkan</button>
                            </div>
                        </div>
                        @if($item!==null)
                            <input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="{{$item->total_price}}">
                        @else
                            <input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="0">
                        @endif
                        <input type="hidden" id="order_id_cek" name="id" value="{{$item !==null ? $item->id : ''}}"/>
                        <a type="button" id="beli_sekarang" class="btn button_add_to_pesan btn-block" onclick="show_modal()" style="padding: 10px 40px; ">Beli Sekarang</a>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade ml-1" id="my_modal_content-detil" role="dialog">
        <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content" style="background: #FDD8AF">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            
            </div>
            <form method="POST" target="_BLANK" action="{{ route('customer.keranjang.pesan', $client_slug) }}">
                @csrf
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-sm-12">
                        
                            <div class="card mx-auto contact_card" style="border-radius:15px;">
                                <div class="card-body">
                                    @if($item!==null)
                                    <input type="hidden" name ="voucher_code_hide_modal" id="voucher_code_hide_modal">
                                    <input type="hidden" name="total_novoucher" id="total_novoucher_val">
                                    <input type="hidden" name="total_pesanan" id="total_pesan_val" value="{{$item->total_price}}">
                                        @else
                                        <input type="hidden" name ="voucher_code_hide_modal"  id="voucher_code_hide_modal">
                                        <input type="hidden" name="total_novoucher" id="total_novoucher_val">
                                        <input type="hidden" name="total_pesanan" id="total_pesan_val" >
                                    @endif
                                    <div class="form-group">
                                    <input type="text" value="{{$item_name !== null ? $item_name->username : ''}}" name="username" class="form-control contact_input @error('name') is-invalid @enderror" placeholder="Name" id="name" required autocomplete="off" autofocus value="{{ old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <hr style="border-top:1px solid rgba(116, 116, 116, 0.507);">
                                    <div class="form-group">
                                        <input type="email" value="{{$item_name !== null ? $item_name->email : ''}}" name="email" class="form-control contact_input @error('email') is-invalid @enderror" placeholder="Email" id="email" required autocomplete="off" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <hr style="border-top:1px solid rgba(116, 116, 116, 0.507);">
                                    <div class="form-group">
                                        <textarea type="text"  name="address" class="form-control contact_input @error('address') is-invalid @enderror" placeholder="Address" id="address" required autocomplete="off" value="{{ old('address') }}">{{$item_name !== null ? $item_name->address : ''}}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <hr style="border-top:1px solid rgba(116, 116, 116, 0.507);">
                                    <div class="form-group">
                                        <input type="tel" minlength="10" maxlength="13" value="{{$item_name !== null ? $item_name->phone : ''}}" name="phone" class="form-control contact_input" placeholder="Phone" id="phone" required autocomplete="off" onkeypress="return hanyaAngka(event)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto text-center">
                                
                            </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <input type="hidden" id="order_id_pesan" name="id" value="{{$item !==null ? $item->id : ''}}"/>
                <button type="submit" class="btn btn-block bt-wa" onclick="pesan_wa()" style="color:#fff;background-color: #6a3137;"><i class="fab fa-whatsapp" style="font-weight: bold;"></i>&nbsp; {{__('Pesan') }}</button>
            </div>
            </form>
        </div>
        
        </div>
    </div>

    <!-- Modal validasi stok -->
    <div class="modal fade ml-1" id="modal_validasi" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" style="background: #FDD8AF">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-12">
                           <div class="text-center mb-3">Mohon maaf...</div> 
                            <div id="body_alert">
                            </div>
                            <div class="text-center mt-3">Stok tidak mencukupi.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="close btn btn-block button_add_to_pesan" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
@endsection
