@extends('customer.layouts.template-nobanner')
@section('content')
@if(session()->has('status'))
<div class="container">
    <div class="row justify-content-center">
        
            <div class="alert alert-success" role="alert" style="position:fixed;top:20%; width:80%; z-index:9999; margin: 0 auto; background:#6a3137; border:none; color:#FDD8AF; font-weight:bold;">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                {{session()->get('status')}}
            </div>
        
    </div>
</div>
@endif
<div class="container" style="margin-top: 80px;">
    <div class="row align-middle">
        <div class="col-sm-12 col-md-12">
            <nav aria-label="breadcrumb" style="margin-left:30px;">
                <ol class="breadcrumb px-0 button_breadcrumb">
                    <li class="breadcrumb-item" style="color: #6a3137 !important;margin-top:30px; margin-left:30px;"><a href="{{Auth::user() ? url('/home_customer') : url('/') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="margin-top:30px;">Riwayat Pesanan</li>
                </ol>
            </nav>
        </div>
    </div>
    @if($order_count < 1)
    <div class="alert alert-success" role="alert" style="position:fixed;top:40%; width:90%; z-index:9999; margin: 0 auto; background:#6a3137; border:none; color:#FDD8AF; font-weight:bold;">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        Tidak ada pesanan
    </div>
    @else
    <div class="row section_content" style="margin:10px;">
        <div class="card mx-auto item_product">
            <div class="card-body m-0 p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" style="font-size:13px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Order date</th>
                                <th>Total price</th>
                                <th width="20%">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=0;?>
                            @foreach($orders as $order)
                            <?php $no++;?>
                            <tr>
                                <td>{{$no}}</td>
                                <td>
                                    @if($order->status == "SUBMIT")
                                    <span class="badge bg-warning text-light">{{$order->status}}</span>
                                    @elseif($order->status == "PROCESS")
                                    <span class="badge bg-info text-light">{{$order->status}}</span>
                                    @elseif($order->status == "FINISH")
                                    <span class="badge bg-success text-light">{{$order->status}}</span>
                                    @elseif($order->status == "CANCEL")
                                    <span class="badge bg-dark text-light">{{$order->status}}</span>
                                    @endif
                                </td>
                                <td>{{$order->created_at}}</td>
                                <td>{{number_format($order->total_price)}}</td>
                                
                                <td>
                                    <button type="button" class="btn btn_default" style="background:#6a3137;color:#fff;font-size:10px"data-toggle="modal" data-target="#detailModal{{$order->id}}">Detail</button>
                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal{{$order->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-lg" style="background: #FDD8AF;">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="detailModalLabel">Detail Pesanan</h6>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row card-body">
                                                        @foreach($order->products as $detil)
                                                        <div class="col-6 col-sm-4 card-img-top" >
                                                            <img src="{{ asset('storage/'.$detil->image)}}" style="height:auto" class="card-img-top" alt="...">
                                                        </div>       
                                                        <div class="col-6 col-sm-8 card-img-top"> 
                                                            <h6>{{$detil->description}}</h6>
                                                            <h6>{{$detil->pivot->quantity}} Pc(s)</h6>
                                                            <p>Rp. {{ number_format($detil->price * $detil->pivot->quantity)}}</p>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn default" style="background:#6a3137;color:#fff" data-dismiss="modal">Close</button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center" >
        <div style="margin-top:-3rem; margin-bottom:1rem;">{{ $orders->links('vendor.pagination.bootstrap-4') }}</div>
    </div>
    @endif
</div>
@endsection
