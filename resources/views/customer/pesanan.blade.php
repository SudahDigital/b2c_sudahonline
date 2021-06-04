@extends('customer.layouts.template-nocart')
@section('title') Profil @endsection
@section('content')
<style>
    
    .modal-dialog-full-width {
        position:absolute;
        right:0;
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        max-width:none !important;
    }

    .modal-content-full-width  {
        height: auto !important;
        min-height: 100% !important;
        border-radius: 0 !important;
    }

    .style-badge{
        padding:7px 10px; 
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom-right-radius:0;
        border-bottom-left-radius:0;
    }

    #tbl_ tbody {
        display:block;
        height:380px;
        overflow:auto;
    }

    thead, tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }

    thead {
        
    }

    .filter-badge{
        border:0.5px solid #1A4066;
    }
    
    .bg-link{
        background:#1A4066; 
    }

    .txt-reset{
        color:#1A4066;
        font-weight:600;
        font-size: 16px;
        padding-left:0;
        margin-top:10px;
    }

    .txt_dtl{
        line-height: 0;
    }

    @media (max-width: 540px){
        .col-list-order{
            margin-left: -1.3rem;
        }

        tbody {
            height:320px;
        }

        .data-list-order{
            font-size:12px;
            
        }

        .status-order{
            font-size:8px;
        }

        .filter-badge{
            font-size: 10px;
        }

        .txt-reset{
            font-size: 12px;
        }
        
    }

    
</style>

    <div class="container" style="">
        <div class="row align-middle">
            <div class="col-sm-12 col-md-12">
                <nav aria-label="breadcrumb" class="float-right mt-0">
                    <ol class="breadcrumb px-0 button_breadcrumb">
                        <li id="prf-brd" class="breadcrumb-pesan-item active mt-2" aria-current="page">Daftar Pesanan</li>&nbsp;
                        <li class="breadcrumb-pesan-item" style="color: #000!important;"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center" style="">
            <div class="col-src-order col-9 px-0">
                <div class="" >
                    <div class="input-group justify-content-end" style="z-index:3;background:#fff;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="height:30px"><i class="fa fa-search"></i></div>
                        </div>
                        <input type="text" class="form-control" id="src_order" onkeyup="search_order()" placeholder="Cari Pesanan" style="height:30px;outline:none;"/>
                    </div>
                </div>
                <div class="col-badge-order col-9 px-0 mt-3" style="z-index:3;">
                    <a href="{{route('pesanan', ['status' =>'submit'])}}" >
                        <span class="style-badge badge {{Request::is('pesanan/submit')  ?'bg-link text-light' : 'badge-light' }}  status-order filter-badge" style="">SUBMIT</span>
                    </a>
                    <a href="{{route('pesanan', ['status' =>'process'])}}">
                        <span class="style-badge badge {{Request::is('pesanan/process')  ?'bg-link text-light' : 'badge-light' }} status-order filter-badge" >PROCESS</span>
                    </a>
                    <a href="{{route('pesanan', ['status' =>'finish'])}}">
                        <span class="style-badge badge {{Request::is('pesanan/finish')  ?'bg-link text-light' : 'badge-light' }} status-order filter-badge">FINISH</span>
                    </a>
                    <a href="{{route('pesanan', ['status' =>'cancel'])}}" class="mr-2">
                        <span class="style-badge badge {{Request::is('pesanan/cancel')  ?'bg-link text-light' : 'badge-light' }} status-order filter-badge">CANCEL</span>
                    </a>
                    <a class="ml-2 txt-reset" href="{{route('pesanan')}}">
                        <span class="style-badge  badge  txt-reset ">Reset Filter</span>
                    </a>
                </div>
                
            </div>
        </div>
        <div class="row justify-content-center" style="">
            <div class="col-list-order col-9">
                
                <div class="row section_content" style="z-index:3;">
                    @if($order_count < 1)
                    <div class="table-responsive mt-3" style="z-index:3;">
                        <table class="table table-striped" style="font-size:13px;">
                            <thead>
                                <tr>
                                    <th width="20%">Status</th>
                                    <th width="50%">Order</th>
                                    <th width="30%">Toko</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center" colspan="3">Data tidak ditemukan</td>
                               </tr>
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div id="tbl_" class="table-responsive mt-3" style="z-index:3;">
                            <table class="table table-striped" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th width="20%">Status</th>
                                        <th width="50%">Order</th>
                                        <th width="30%">Toko</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=0;?>
                                    @foreach($orders as $order)
                                    <?php $no++;?>
                                    <tr>
                                        <td width="20%" style="padding-left:7px;">
                                            @if($order->status == "SUBMIT")
                                            <span class="style-badge badge bg-warning text-white status-order">{{$order->status}}</span>
                                            @elseif($order->status == "PROCESS")
                                            <span class="style-badge style-badge badge bg-info text-light status-order">{{$order->status}}</span>
                                            @elseif($order->status == "FINISH")
                                            <span class="style-badge  badge bg-success text-light status-order">{{$order->status}}</span>
                                            @elseif($order->status == "CANCEL")
                                            <span class="style-badge badge bg-danger text-light status-order">{{$order->status}}</span>
                                            @endif
                                        </td>
                                        <td width="50%">
                                            <span class="data-list-order"><p class="mb-n1">Tanggal Order</p></span>
                                            <b class="data-list-order mb-4"> {{$order->created_at}}</b><br>

                                            <!--<span class="data-list-order"><p class="mb-n1 mt-2">Total Quantity</p></span>
                                            <b class="data-list-order"> {{$order->totalQuantity}}</b><br>-->

                                            <span class="data-list-order"><p class="mb-n1 mt-2">Total Harga</p></span>
                                            <b class="data-list-order"> Rp. {{number_format($order->total_price)}}</b><br>
                                            
                                            <a onclick="open_detail_list('{{$order->id}}')" style="cursor: pointer;">
                                                <span class="style-badge badge text-light mt-2"
                                                    style="padding:5px 10px;background:#1A4066">
                                                    <small><b>Detail Pesanan</b></small>
                                                </span>
                                            </a>
                                            
                                        </td>
                                        <td width="30%">
                                            <span class="data-list-order">{{$order->customers->store_name}}</span>
                                            @if($order->customers->status == 'NEW')<span class="badge bg-pink">New</span>@endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade modal-paket" id="modalDetilList" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-paket modal-lg" role="document">
            <div class="modal-content modal-content-paket">
                <div class="modal-body pb-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div id="DataListOrder">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        if ($(window).width() < 769) {
            $('.modal-dialog-paket').removeClass('modal-lg');
            $('.modal-dialog-paket').addClass('modal-dialog-full-width');
            $('.modal-content-paket').addClass('modal-content-full-width');
        }

        if ($(window).width() <= 600) {
            //$('#prf-brd').removeClass('mt-1');
            $('.col-list-order'). removeClass('col-9').addClass('col-12');
            $('.col-src-order'). removeClass('col-9').addClass('col-12').addClass('mt-n3').removeClass('px-0');
            $('.col-badge-order'). removeClass('col-9').addClass('col-12');
            $('.txt-reset'). removeClass('ml-2');
            //$('#prf-brd').addClass('mt-2');
        } 
        if ($(window).width() <= 411) {
            $('.col-list-order').addClass('ml-n3');
            //$('.contact-row').addClass('mt-5');
        } 
    </script>
@endsection
