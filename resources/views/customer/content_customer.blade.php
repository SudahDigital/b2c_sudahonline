@extends('customer.layouts.template')
@section('title')
Home    
@endsection
@section('content')
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }

    .image-logo-confirm img{
            width:100px;
            height:auto;
    }

    @media only screen and (max-width:1920px){
        .image-logo-confirm img{
            width:90px;
            height:auto;
            margin-left:9.5rem;
            top:0;
        }
    }

    @media only screen and (max-width:1366px){
        .image-logo-confirm img{
            width:70px;
            height:auto;
            margin-left:10rem;
            top:0;
        }
    }

    @media only screen and (max-width:1024px){
        .image-logo-confirm img{
            width:60px;
            height:auto;
            margin-left:11rem;
            top:0;
        }
    }
    
    @media only screen and (max-width:768px){
        .image-logo-confirm img{
            width:50px;
            height:auto;
            margin-left:0rem;
        }
    }

    @media only screen and (max-width:600px){
        .image-logo-confirm img{
            width:43px;
            height:auto;
            margin-left:-1.3rem;
        }

        .login-label h3{
            font-size:20px;
        }
    }
</style>

    @if(session('sukses_peesan'))
    <div class="alert alert-success">
        {{session('sukses_pesan')}}
    </div>
    @endif
    
    <!--top product-->
    @if($top_count > 0 )
    <div id="top_product" style="background:#DADADA !important;">
        <img src="{{ asset('assets/image/dot-topproduct.png') }}" class="dot-content-top-right" style="" alt="dot-topproduct">
        <img src="{{ asset('assets/image/shape-content.jpg') }}" class="shape-content-bottom-right" style="" alt="shape-content">
        <img src="{{ asset('assets/image/dot-bottom-left-content.jpg') }}" class="dot-content-bottom-left" style="" alt="dot-bottom-left-content">
        <div class="container mb-n4" style="">
            <div class="row">
                <div class="col-8">
                    <nav aria-label="breadcrumb" class="" >
                        <ol class="breadcrumb pt-4 mt-3" style="background-color:#DADADA !important;">
                            <h2 class="breadcrumb-item">Our</h2>
                            <h2 class="breadcrumb-item active" aria-current="page">Product</h2>
                        </ol>
                    </nav>
                </div>
                <div class="col-4 ">
                    <div id="dropfilter" class="dropfilter dropdown pt-4 mt-3 float-right" style=""> 
                        <button class="btn filter_category" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b>Filter</b>
                            <i class="fas fa-caret-down fa-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="height: auto;max-height: 200px;overflow-x: hidden; border-bottom-left-radius:1rem;border-bottom-right-radius:1rem;">
                            <a class="dropdown-item" href="{{ url('/') }}" style="color: #1A4066;"><b>Semua Produk</b></a>
                            @foreach($categories as $filter_product)
                                <a class="dropdown-item" href="{{route('home_customer', ['cat'=>$filter_product->id] )}}" style="color: #000;"><b>{{$filter_product->name}}</b></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container list-product" style="">
            <div class="row mt-0">
                <div class="col-md-12 mt-4 menu-wrapper">
                    <div class="row section_content flex-row flex-nowrap menu" style="overflow-x:auto;overflow-y:hidden;z-index:2222; ">
                        @foreach($top_product as $value_top)
                        <div id="product_list"  class="col-6 col-md-3 d-flex mx-0 item" style="z-index: 1">
                            <div class="card mx-auto d-flex item_product">
                                @if($value_top->discount > 0)
                                <div class="ribbon"><span class="span-ribbon">{{$value_top->discount}}% OFF</span></div>
                                @endif
                                <a>
                                    <img style="" src="{{ asset('storage/'.(($value_top->image!='') ? $value_top->image : 'no_image_availabl.png').'') }}" class="img-fluid h-100 w-100 img-responsive" alt="...">
                                </a>
                                <div class="card-body d-flex flex-column" style="background-color:#1A4066;">
                                    @if($stock_status->stock_status == 'ON')
                                        @if($value_top->stock == 0)
                                            <span class="badge badge-warning ml-1">Sisa stok 0</span>
                                        @endif
                                    @endif
                                    <div class="float-left px-1 py-2" style="width: 100%;">
                                        <p class="product-price-header mb-0" style="">
                                            {{$value_top->Product_name}}
                                        </p>
                                    </div>
                                    @if($value_top->discount > 0)
                                        <div class="d-inline-block">
                                            <div class="text-left">
                                                <p class="product-price mt-0 mb-0 ml-1" style="color:#ffff;"><del><b><i>Rp. {{ number_format($value_top->price, 0, ',', '.') }}'-</i></b> </del></p>
                                            </div>
                                        </div>
                                        <div class="float-left px-1 py-2" style="">
                                            <p style="line-height:1; bottom:0" class="product-price mb-0 " id="productPrice_top{{$value_top->id}}" style="">Rp. {{ number_format($value_top->price_promo, 0, ',', '.') }}'-</p>
                                        </div>
                                    @else
                                        <div class="float-left px-1 py-2" style="">
                                            <p style="line-height:1; bottom:0" class="product-price mb-0 " id="productPrice_top{{$value_top->id}}" style="">Rp. {{ number_format($value_top->price, 0, ',', '.') }},-</p>
                                        </div>
                                    @endif
                                    <table width="100%" class="hdr_tbl_cart mt-auto">
                                        <tbody>
                                        <tr>
                                            <td class="tbl_cart" valign="middle" style="" rowspan="2">
                                                <input type="hidden" id="jumlah_top{{$value_top->id}}" name="quantity" value="1">
                                                <input type="hidden" id="harga_top{{$value_top->id}}" name="price" value="{{ $value_top->price }}">
                                                <input type="hidden" id="top{{$value_top->id}}" name="Product_id" value="{{$value_top->id}}">
                                                <button class="btn btn-block button_add_to_cart respon" onclick="add_tocart_top('{{$value_top->id}}')" {{($value_top->stock == 0) && ($stock_status->stock_status == 'ON') ? 'disabled' : ''}}>Tambah</button>
                                                
                                            </td>
                                            <td width="30%" align="left" id="td-text-quantity" class="td-text-quantity" valign="middle" rowspan="2" >
                                                <input type="number" id="show_top{{$value_top->id}}" onkeyup="input_qty_top('{{$value_top->id}}')" class="form-control input-sm mr-0 px-1 font-weight-bold" value="1" style="color:#000;font-weight:300;text-align:center;">
                                            </td>
                                            <td width="10%" class="td-btn-plus" align="center" valign="middle" bgcolor="#ffffff" style="border-top-left-radius:5px;border-top-right-radius:5px;">
                                                <a class="button_plus" onclick="button_plus_top('{{$value_top->id}}')"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="10%" align="center" valign="middle" bgcolor="#ffffff" style="border-bottom-left-radius:5px;border-bottom-right-radius:5px;">
                                                <a class="button_minus" onclick="button_minus_top('{{$value_top->id}}')" id="btn_min" style=""><i class="fa fa-minus" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!--
                        <div class="col-md-12">
                            <div class="row justify-content-center" >
                            <div class="page paging" style="margin-top:0; margin-bottom:1rem;">/*$product->appends(Request::all())->onEachSide(5)->links('vendor.pagination.bootstrap-4') */</div>
                            </div>
                        </div>
                        -->
                    </div>
                    <div class="paddles d-none d-md-block d-md-none">
                        @if($top_count > 4)
                        <button class="left-paddle paddle paddles_hide">
                            <i class="fa fa-angle-double-left" style=""></i>
                        </button>
                        <button class="right-paddle paddle" style="text-decoration: none;">
                            <i class="fa fa-angle-double-right" style=""></i>
                        </button>
                        @endif
                    </div>

                    <div class="paddles d-md-none">
                        @if($top_count > 2)
                        <button class="left-paddle paddle paddles_hide">
                            <i class="fa fa-angle-double-left" style=""></i>
                        </button>
                        <button class="right-paddle paddle" style="text-decoration: none;">
                            <i class="fa fa-angle-double-right" style=""></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!--non product-->
    <div style="background:#ffff">
        @if($top_count < 1)
            <img src="{{ asset('assets/image/dot-topproduct.png') }}" class="dot-content-top-right" style="" alt="dot-topproduct">
        @endif
        <img src="{{ asset('assets/image/shape-content.jpg') }}" class="shape-content-bottom-right" style="" alt="shape-content">
        <img src="{{ asset('assets/image/dot-bottom-left-content.jpg') }}" class="dot-content-bottom-left" style="" alt="dot-bottom-left-content">
        @if($top_count < 1)
        <div class="container mb-n4" style="">
            <div class="row">
                <div class="col-8">
                    <nav aria-label="breadcrumb" class="" >
                        <ol class="breadcrumb pt-4 mt-3" style="background-color:#fff !important;">
                            <h2 class="breadcrumb-item">Our</h2>
                            <h2 class="breadcrumb-item active" aria-current="page">Product</h2>
                        </ol>
                    </nav>
                </div>
                <div class="col-4 ">
                    <div id="dropfilter" class="dropfilter dropdown pt-4 mt-3 float-right">
                        <button class="btn filter_category" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b>Filter</b>
                            <i class="fas fa-caret-down fa-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="height: auto;max-height: 200px;overflow-x: hidden; border-bottom-left-radius:1rem;border-bottom-right-radius:1rem;">
                            <a class="dropdown-item" href="{{ url('/') }}" style="color: #1A4066;"><b>Semua Produk</b></a>
                            @foreach($categories as $filter_product)
                                <a class="dropdown-item" href="{{route('home_customer', ['cat'=>$filter_product->id] )}}" style="color: #000;"><b>{{$filter_product->name}}</b></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="container list-product" style="">
            <div class="row mt-0">
                <div class="col-md-12 mt-4">
                    <div class="row section_content">
                    @foreach($product as $value)
                    <div id="product_list"  class="col-6 col-md-3 d-flex mx-0" style="z-index: 1">
                        <div class="card mx-auto d-flex item_product">
                            @if($value->discount > 0)
                            <div class="ribbon"><span class="span-ribbon">{{$value->discount}}% OFF</span></div>
                            @endif
                            
                            <a>
                                <img style="" src="{{ asset('storage/'.(($value->image!='') ? $value->image : 'no_image_availabl.png').'') }}" class="img-fluid h-100 w-100 img-responsive" alt="...">
                            </a>
                            <div class="card-body d-flex flex-column" style="background-color:#1A4066;">
                                @if($stock_status->stock_status == 'ON')
                                    @if($value->stock == 0)
                                        <span class="badge badge-warning ml-1">Sisa stok 0</span>
                                    @endif
                                @endif
                                <div class="float-left px-1 py-2" style="width: 100%;">
                                    <p class="product-price-header mb-0" style="">
                                        {{$value->Product_name}}
                                    </p>
                                </div>
                                @if($value->discount > 0)
                                    <div class="d-inline-block">
                                        <div class="text-left">
                                            <p class="product-price mt-0 mb-0 ml-1" style="color:#ffff;"><del><b><i>Rp. {{ number_format($value->price, 0, ',', '.') }}'-</i></b> </del></p>
                                        </div>
                                    </div>
                                    <div class="float-left px-1 py-2" style="">
                                        <p style="line-height:1; bottom:0" class="product-price mb-0 " id="productPrice{{$value->id}}" style="">Rp. {{ number_format($value->price_promo, 0, ',', '.') }}'-</p>
                                    </div>
                                @else
                                    <div class="float-left px-1 py-2" style="">
                                        <p style="line-height:1; bottom:0" class="product-price mb-0 " id="productPrice{{$value->id}}" style="">Rp. {{ number_format($value->price, 0, ',', '.') }},-</p>
                                    </div>
                                @endif
                                <div class="mb-0 mt-auto" >
                                    <table width="100%" class="hdr_tbl_cart ">
                                        <tbody>
                                        <tr>
                                            <td class="tbl_cart" valign="middle" style="" rowspan="2">
                                                <input type="hidden" id="jumlah{{$value->id}}" name="quantity" value="1">
                                                <input type="hidden" id="harga{{$value->id}}" name="price" value="{{ $value->price }}">
                                                <input type="hidden" id="{{$value->id}}" name="Product_id" value="{{$value->id}}">
                                                <button class="btn btn-block button_add_to_cart respon" onclick="add_tocart('{{$value->id}}')" {{($stock_status->stock_status == 'ON')&&($value->stock == 0) ? 'disabled' : ''}}>Tambah</button>
                                                
                                            </td>
                                            <td width="30%" align="left" id="td-text-quantity" class="td-text-quantity" valign="middle" rowspan="2" >
                                                <input type="number" id="show_{{$value->id}}" onkeyup="input_qty('{{$value->id}}')" class="form-control input-sm mr-0 px-1 font-weight-bold" value="1" style="color:#000;font-weight:300;text-align:center;">
                                            </td>
                                            <td width="10%" class="td-btn-plus" align="center" valign="middle" bgcolor="#ffffff" style="border-top-left-radius:5px;border-top-right-radius:5px;">
                                                <a class="button_plus" onclick="button_plus('{{$value->id}}')"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="10%" align="center" valign="middle" bgcolor="#ffffff" style="border-bottom-left-radius:5px;border-bottom-right-radius:5px;">
                                                <a class="button_minus" onclick="button_minus('{{$value->id}}')" id="btn_min" style=""><i class="fa fa-minus" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>                                    
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!--
                    <div class="col-md-12">
                        <div class="row justify-content-center" >
                        <div class="page paging" style="margin-top:0; margin-bottom:1rem;">/*$product->appends(Request::all())->onEachSide(5)->links('vendor.pagination.bootstrap-4') */</div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
    
    <div id="accordion" class="fixed-bottom" style="border-radius:0;z-index: 1;">
        <div class="card" style="border-radius:0;">
            <a role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="collapsed">
                <div id="card-cart" class="card-header pt-1" style="border-radius:0;">
                    <div class="card-cart container">
                        <table class="table borderless">
                            <tr>
                                <td align="left" id="td_itm" width="40%">
                                    <h5 style="color:#000">{{$total_item}} Item</h5>
                                </td>
                                <td align="middle"  id="td_crv" width="20%">
                                    <i class="fas fa-chevron-up" style=""></i>
                                </td>
                                <td align="right" id="td_krm-order" width="40%">
                                    <h5 class="pull-right" style="color: #000">Kirim Order&nbsp;&nbsp;<img src="{{ asset('assets/image/right-arrow.png') }}" width="20" class="my-auto" alt="right-arrow"></h5>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </a>
            
            <div id="{{$total_item > 0 ? 'collapse-4' : '' }}" class="collapse" data-parent="#accordion">
                <div id="cont-collapse" class="container">
                    <div class="card-body" id="card-detail" style="">
                        <div class="col-md-12 mt-n4" style="padding-bottom:10rem;">
                            
                            @if($total_item > 0)
                                @php
                                $groupby_paket = \DB::table('order_product')
                                                ->where('order_id',$item->id)
                                                ->whereNotNull('paket_id')
                                                ->whereNotNull('group_id')
                                                ->whereNull('bonus_cat')
                                                ->distinct()
                                                ->get(['paket_id','group_id']);
                                $krj_paket=count($groupby_paket);
                                    
                                @endphp
                                @if($krj_paket > 0)
                                <p id="p-title1" class="mb-2" style="font-weight:700;color: #153651;font-family: Montserrat;">Paket</p>
                                <table class="table-detail" width="100%">
                                    <tbody>
                                    @foreach($groupby_paket as $dtl_pkt)

                                                @php
                                                    $paket_name =\App\Paket::where('id',$dtl_pkt->paket_id)
                                                                ->first();
                                                    $group_name =\App\Group::where('id',$dtl_pkt->group_id)
                                                                ->first();           
                                                @endphp
                                                <tr class="pb-0">
                                                    <td width="30%" class="img-detail-cart" valign="top" style="padding-top:3%;">
                                                        <img src="{{ asset('storage/'.(($group_name->group_image!='') ? $group_name->group_image : 'no_image_availabl.png').'') }}" 
                                                        class="image-detail"  alt="...">
                                                    </td>
                                                    <td width="60%" class="td-desc-detail" align="left" valign="top" style="padding-top:3%;">
                                                        <p style="color: #000">{{ $paket_name->display_name}},</p>
                                                        <p style="color: #000">{{ $group_name->display_name}}</p>
                                                        @php
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
                                                        @endphp
                                                        <h2 style="font-weight:700;color: #153651;font-family: Montserrat;">Rp. {{ number_format($pkt_pirce, 0, ',', '.') }},-</h2>
                                                        
                                                        <p style="color: #000"><span>Qty</span><span class="d-inline ml-2" style="color: #153651;font-weight:900;">{{$pkt_total_krj}}</span></p>
                                                        <a onclick="open_detail_pkt('{{$item->id}}','{{$dtl_pkt->paket_id}}','{{$dtl_pkt->group_id}}')" style="cursor: pointer"><span class="badge badge-secondary">Detail Paket</span></a>

                                                    </td>
                                                    <td width="15%" align="right" valign="top" style="padding-top:3%;">
                                                        <button class="btn btn-default" onclick="delete_kr_pkt('{{$item->id}}','{{$dtl_pkt->paket_id}}','{{$dtl_pkt->group_id}}')" style="">X</button>
                                                        <input type="hidden"  id="order_id_delete_pkt" name="order_id" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="border-bottom: 1px solid #ddd;">
                                                        <div class="row">
                                                            <div class="col-3 pt-1 row-bonus-text">
                                                                <p class="" style="font-weight:700;color: #153651;font-family: Montserrat;">Bonus :</p>
                                                            </div>
                                                            <div class="col-9 row-bonus-detail">
                                                                @php
                                                                    $groupby_bns = \App\order_product::where('order_id',$item->id)
                                                                                    ->where('paket_id',$dtl_pkt->paket_id)
                                                                                    ->where('group_id',$dtl_pkt->group_id)
                                                                                    ->whereNotNull('bonus_cat')
                                                                                    ->get();
                                                                                    //dd($groupby_bns);
                                                                @endphp
                                                                @foreach($groupby_bns as $bns)
                                                                    @php
                                                                        $prd_bns =\App\product::findOrfail($bns->product_id);
                                                                    @endphp
                                                                    <p class="d-none d-md-block d-md-none mt-2 row-bonus-detail-p" style="color: #000;margin-left:-11rem;">* {{$prd_bns->Product_name}}&nbsp;<span style="color: #153651;">({{$bns->quantity}})</span></p>
                                                                    <p class="d-md-none mt-2 ml-n5" style="color: #000;font-size:3vw;">* {{ $prd_bns->Product_name}}&nbsp;<span style="color: #153651;">({{$bns->quantity}})</span></p>
                                                                    
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                                @if(($krj_paket > 0) && (count($keranjang) > 0))        
                                    <p id="p-title2" class="mt-4 mb-2" style="font-weight:700;color: #153651;font-family: Montserrat;">Produk Non-Paket</p>
                                @endif
                            @endif
                            
                            <table class="table-detail" width="100%" >
                                <tbody>
                                    @foreach($keranjang as $detil)
                                    <tr>
                                        <td width="30%" class="img-detail-cart" valign="middle" style="border-bottom: 1px solid #ddd;padding-top:3%;">
                                            <img src="{{ asset('storage/'.(($detil->image!='') ? $detil->image : 'no_image_availabl.png').'') }}" 
                                            class="image-detail"  alt="...">   
                                        </td>
                                        <td width="60%" class="td-desc-detail" align="left" valign="top" style="border-bottom: 1px solid #ddd;padding-top:3%;">
                                            <p style="color: #000">{{ $detil->Product_name}}</p>
                                            <?php 
                                            if($detil->discount > 0){
                                                $total = $detil->price_promo * $detil->quantity;
                                            }else{
                                                $total=$detil->price * $detil->quantity;
                                            }
                                            ?>
                                            <h2 id="productPrice_kr{{$detil->product_id}}" style="font-weight:700;color: #153651;font-family: Montserrat;">Rp. {{ number_format($total, 0, ',', '.') }},-</h2>
                                            <table width="20%" class="tabel-quantity">
                                                <tbody>
                                                    <tr>
                                                        <td width="3%" class="" align="left" valign="middle" rowspan="2">
                                                            <p style="color: #000">Qty</p>
                                                            <input type="hidden" id="order_id{{$detil->product_id}}" name="order_id" value="{{$detil->order_id}}">
                                                            @if($detil->discount > 0)
                                                            <input type="hidden" id="harga_kr{{$detil->product_id}}" name="price" value="{{$detil->price_promo}}">
                                                            @else
                                                            <input type="hidden" id="harga_kr{{$detil->product_id}}" name="price" value="{{$detil->price}}">
                                                            @endif
                                                            <input type="hidden" id="id_detil{{$detil->product_id}}" value="{{$detil->id}}">
                                                            <input type="hidden" id="jmlkr_{{$detil->product_id}}" name="quantity" value="{{$detil->quantity}}">    
                                                        </td>
                                                        <td width="3%" class="" align="left" valign="middle" rowspan="2">
                                                            <p id="show_kr_{{$detil->product_id}}" class="d-inline" style="">{{$detil->quantity}}</p>
                                                        </td>
                                                        <td width="1%" align="center" valign="middle" bgcolor="#1A4066" style="border-top-left-radius:5px;border-top-right-radius:5px;">
                                                            <button class="button_plus" onclick="button_plus_kr('{{$detil->product_id}}')" style="background:none; border:none; color:#ffffff;outline:none;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="1%" align="middle" valign="middle" bgcolor="#1A4066" style="border-bottom-left-radius:5px;border-bottom-right-radius:5px;">
                                                            <button class="button_minus" onclick="button_minus_kr('{{$detil->product_id}}')" style="background:none; border:none; color:#ffffff;outline:none;"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="15%" align="right" valign="top" style="border-bottom: 1px solid #ddd;padding-top: 10%;">
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
                                <input type="hidden" class="form-control" id="voucher_code_hide">
                            @if($total_item > 0)
                                <!--
                                <div class="input-group mb-2 mt-2">
                                    <input type="text" class="form-control" id="voucher_code" 
                                    placeholder="Gunakan Kode Diskon" aria-describedby="basic-addon2" required style="background:#ffcc94;outline:none;">
                                    <div class="input-group-append" required>
                                        <button class="btn " type="submit" onclick="btn_code('')" style="background:#6a3137;outline:none;color:white;">Terapkan</button>
                                    </div>
                                </div>
                                
                                <div id="divchecktunai" class="custom-control custom-checkbox checkbox-lg ml-n3 mb-4 mt-n2">
                                    <input  type="checkbox" class="custom-control-input" id="checktunai" checked value="Cash">
                                    <label class="custom-control-label" for="checktunai" style="color: #000;font-weight:600;">Pembayaran Tunai</label>
                                </div>
                                -->
                                <div id="div_total" class="row float-left mt-2">
                                    <p class="mt-1" style="color: #000;font-weight:bold; ">Total Harga</p>&nbsp;
                                    @if($item!==null)
                                    <h2 id="total_kr_" style="font-weight:700;color: #153651;font-family: Montserrat;">Rp. {{number_format($item->total_price , 0, ',', '.')}},-</h2>
                                    <input type="hidden" id="total_kr_val" value="{{$item->total_price}}">
                                        @else
                                    <h2 id="total_kr_" style="font-weight:700;color: #153651;font-family: Montserrat;">Rp. 0,-</h2>
                                    <input type="hidden" id="total_kr_val" value="0">
                                    @endif
                                </div>
                                

                                @if($item!==null)
                                    <input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="{{$item->total_price}}">
                                @else
                                    <input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="0">
                                @endif
                                <input type="hidden" id="order_id_cek" name="id" value="{{$item !==null ? $item->id : ''}}"/>
                                <div id="chk-bl-btn" class="row justify-content-end my-auto">
                                    <a type="button" id="beli_sekarang" class="btn button_add_to_pesan float-right mb-2" onclick="show_modal()" style="padding: 10px 20px; ">Pesan Sekarang <i class="fab fa-whatsapp" aria-hidden="true" style="color: #ffffff !important; font-weight:900;"></i></a>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pesan wa--> 
    <div class="modal fade right ml-0" id="my_modal_content" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
        <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
            <div class="modal-content-full-width modal-content ">
                <div class="modal-body">
                    <div id="message" class="row justify-content-center"></div>
                    <img src="{{ asset('assets/image/dot-top-right-profil.jpg') }}" class="dot-top-right-nocart"  
                    style="" alt="dot-top-right-profil">
                    <img src="{{ asset('assets/image/dot-bottom-left-profil.jpg') }}" class="dot-bottom-left-nocart"  
                    style="" alt="dot-bottom-left-profil">
                    <img src="{{ asset('assets/image/shape-profil-bottom.jpg') }}" class="shape-bottom-right-nocart"  
                    style="" alt="shape-profil-bottom">
                    <button type="button" class="btn btn-warning btn-circle" data-dismiss="modal" style="position:absolute;z-index:99999;"><i class="fa fa-times"></i></button>
                    <!--
                    <img src="{{ asset('assets/image/dot-top-right.png') }}" class="dot-top-right"  
                    style="" alt="dot-top-right">
                    <img src="{{ asset('assets/image/dot-bottom-left.png') }}" class="dot-bottom-left"  
                    style="" alt="dot-bottom-left">
                    <img src="{{ asset('assets/image/shape-bottom-right.png') }}" class="shape-bottom-right"  
                    style="" alt="shape-bottom-right">
                    <button type="button" class="btn btn-warning btn-circle" data-dismiss="modal" style="position:absolute;z-index:99999;"><i class="fa fa-times"></i></button>
                    -->
                    <div class="container image-logo-confirm">
                        <div class="d-flex justify-content-start mx-auto">
                            <div class="col-md-1" style="z-index: 2">
                                <img src="{{ asset('assets/image/LOGO MEGACOOLS_DEFAULT.png') }}" class="img-thumbnail" style="background-color:transparent; border:none;position:absolute;" alt="LOGO MEGACOOLS_DEFAULT">  
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-md-12 login-label py-3 label-confirm mb-4 mt-4" style="z-index: 4">
                        <h3 style="color: #1A4066 !important;">Konfirmasi Pesanan</h3>
                    </div>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-5 login-label label-confirm mt-4" style="z-index: 4">
                            <div id="PreviewToko_Produk" style="overflow: hidden;">
                                
                            </div>
                            
                            <form class="form-inline" method="POST" id="ga_pesan_form" target="_BLANK" action="{{ route('customer.keranjang.pesan') }}">
                                @csrf
                                <div class="col-md-5 px-0 pt-3">
                                    <p class="text-left mb-1" style="color: #1A4066 !important;">Pilih Metode Pembayaran</p>
                                </div>
                                @if($item!==null)
                                <input type="hidden" name ="voucher_code_hide_modal" id="voucher_code_hide_modal">
                                <input type="hidden" name="total_novoucher" id="total_novoucher_val">
                                <input type="hidden" name="total_pesanan" id="total_pesan_val" value="{{$item->total_price}}">
                                @else
                                    <input type="hidden" name ="voucher_code_hide_modal"  id="voucher_code_hide_modal">
                                    <input type="hidden" name="total_novoucher" id="total_novoucher_val">
                                    <input type="hidden" name="total_pesanan" id="total_pesan_val" >
                                @endif
                                <div class="col-md-7 p-0 ">
                                    <select name="check_tunai_value"  id="check_tunai" style="width:100%;" class="form-control" required>
                                        <option data-icon="fa-check-circle" value="Cash">&nbsp;&nbsp;Cash</option>
                                        <option data-icon="fa-check-circle" value="TOP">&nbsp;&nbsp;TOP</option>
                                        <!--
                                        <option data-icon="fa-check-circle" value="TOP 7 Days">&nbsp;&nbsp;TOP 7 Days</option>
                                        <option data-icon="fa-check-circle" value="TOP 14 Days">&nbsp;&nbsp;TOP 14 Days</option>
                                        <option data-icon="fa-check-circle" value="TOP 30 Days">&nbsp;&nbsp;TOP 30 Days</option>
                                        -->
                                    </select>
                                </div>
                                <div class="col-md-12 px-0 mt-4">
                                    <div class="form-group">
                                        <textarea name="notes" class="form-control p-3" rows="5" placeholder="Note..."
                                        style="width: 100%;
                                        border-top-left-radius:25px;
                                        border-top-right-radius:25px;
                                        border-bottom-right-radius:0;
                                        border-bottom-left-radius:0;"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 px-0 mt-2">
                                    
                                
                                    <input type="hidden" id="order_id_pesan" name="id" value="{{$item !==null ? $item->id : ''}}"/>
                                    <button type="submit" id="ga_pesan" onclick="pesan_wa()" class="btn btn-success float-right btn-preview-order"><i class="fab fa-whatsapp fa-1x" aria-hidden="true" style="color: #ffffff !important; font-weight:900;"></i>&nbsp;{{__('Pesan Sekarang') }}</button>
                                </div>
                            </form>
                            <button type="submit" onclick="cancel_wa()" class="btn btn-danger btn-preview-cancel"
                                style="">
                                <i class="fa fa-times fa-1x" aria-hidden="true" style="color:#fff;font-weight:900;">
                                </i>&nbsp;{{__('Batalkan Pesanan') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal validasi stok -->
    <div class="modal fade" id="modal_validasi" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" style="">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-12">
                        <div class="text-center mb-3" style="color:#1A4066;font-weight:500">Mohon maaf...</div>
                        <hr> 
                            <div id="body_alert">
                            </div>
                            <div class="text-left mt-2 " style="color:#1A4066;font-weight:400"><small>Stok tidak mencukupi.</small></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-block button_add_to_cart" data-dismiss="modal" style="">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal detail paket -->
    <div class="modal fade" id="DeatailPaket" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <p style="font-weight:700;color: #153651;font-family: Montserrat;">Detail Paket</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class='table small'>
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jml</th>
                                <th>Total Harga(Rp)</th>
                            </tr>
                        </thead>
                        <tbody id='body_detail_pkt'>
            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   
<script>
    if($(window).width() <1450){
        $('.label-confirm').removeClass('col-md-5').addClass('col-md-7').addClass('px-4');
    }

    if ($(window).width() < 1220) {
        $('.row-bonus-detail-p').addClass('ml-n4');
        $('.label-confirm').removeClass('mb-4').removeClass('mt-4');
    }

    if($(window).width() < 769){
        $('.label-confirm').removeClass('col-md-5').addClass('col-md-11').addClass('px-4');
    }

    if ($(window).width() < 601) {
        $('#div_total').removeClass('float-left');
        //$('#div_total').addClass('justify-content-center');
        $('#div_total').removeClass('mt-2');
        $('#div_total').addClass('mb-2');
        $('#beli_sekarang').removeClass('float-right');
        $('#beli_sekarang').addClass('btn-block');
        $('#beli_sekarang').addClass('mb-0');
        $('#chk-bl-btn').removeClass('justify-content-end');
        $('#chk-bl-btn').addClass('justify-content-center');
        $('#divchecktunai').addClass('mb-2');
        $('.dropfilter').removeClass('mt-3');
        $('#p-title1').addClass('ml-n3');
        $('#p-title2').addClass('ml-n3');
        //$('.dtl_prd_bns').style.fontSize='medium';
        //$('#dropfilter').addClass('mt-2');
        $('.row-bonus-text').removeClass('col-3');
        $('.row-bonus-text').addClass('col-4');
        $('.row-bonus-detail').removeClass('col-9');
        $('.row-bonus-detail').addClass('col-8');
        $('.image-logo-login').removeClass('container');
    }
    if ($(window).width() <= 480) {
        $('#cont-collapse').removeClass('container');
        //$('.card-cart').removeClass('container');
    }

    if($(window).width()<= 411){
        $('.btn-preview-cancel').addClass('btn-block');
        $('.btn-preview-order').addClass('btn-block').addClass('mt-5')
    }
     
</script>
@endsection


