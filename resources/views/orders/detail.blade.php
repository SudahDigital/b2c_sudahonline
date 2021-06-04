@extends('layouts.master')
@section('title') Details Order @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" action="{{route('orders.update', [$order->id])}}">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        
        <div class="form-group form-float">
            <label class="form-label">Customer</label>
                <ul>
                    <small><b>Name :</b> {{$order->customers->store_name}}</small>
					@if($order->customers->status == 'NEW')<span class="badge bg-pink">New</span>@endif
					<br>
                    <small><b>Contact Person :</b> {{$order->customers->name}}</small><br>
					<small><b>Email :</b> {{$order->customers->email}}</small><br>
					<small><b>Addr :</b> {{$order->customers->address}}</small><br>
					<small><b>Phone :</b> {{$order->customers->phone}}</small><br>
                    <small><b>Office Phone :</b> {{$order->customers->phone_store}}</small><br>
                    <small><b>Owner Phone :</b> {{$order->customers->phone_owner}}</small><br>
					<small><b>Sales Rep :</b> {{$order->users->name}} <span class="badge {{$order->user_loc == 'On Location' ? 'bg-green' : 'bg-black'}}">{{$order->user_loc}}</span></small><br>
                    <small><b>Payment Term :</b> 
						{{$order->payment_method}}
					</small><br>
                    <small><b>Notes :</b> {{$order->notes}}</small><br>
                </ul>
                    <!--<input type="text" class="form-control" autocomplete="off" value="" disabled>-->
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control"  autocomplete="off"  value="{{$order->created_at}}" disabled>
                <label class="form-label">Order date</label>
            </div>
        </div>
        <label class="form-label">Product Orders</label>
        @if(count($order->products_nonpaket) > 0)
            <div class="form-group">
                <table width="100%" class="table table-hover">
                    <thead>
                        <th width="50%" style="padding-left:10px;"><small>* Regular Product</small></th>
                        <th width="" style="padding-left:10px;"><small>Quantity </small> </th>
                        <th width="" style="padding-left:10px;"><small>Price</small> </th>
                        <!--<th width="" style="padding-left:10px;"><small>Discount(%)</small> </th>
                        <th width="" style="padding-left:10px;"><small>Price After Discount</small></th>-->
                        <th width="" class="text-right"><small>Sub Total</small></th>
                    </thead>
                    <tbody>
                        @foreach($order->products_nonpaket as $p)
                        <tr>
                            <td style="padding-top:10px;">{{$p->description}}</td>
                            <td style="padding-top:5px;">{{$p->pivot->quantity}}</td>
                            <td style="padding-top:5px;">Rp. {{number_format($p->pivot->price_item, 0, ',', '.')}}</td>
                            <!--<td style="padding-top:5px;">{{$p->pivot->discount_item}}</td>
                            <td style="padding-top:5px;">
                                @if(($p->pivot->price_item_promo != NULL) && ($p->pivot->price_item_promo > 0))
                                {{number_format($p->pivot->price_item_promo, 0, ',', '.')}}
                                @else
                                ---
                                @endif
                            </td>-->
                            <td align="right">
                                @if(($p->pivot->discount_item != NULL) && ($p->pivot->discount_item > 0))
                                Rp. {{number_format($p->pivot->price_item_promo * $p->pivot->quantity, 0, ',', '.')}}
                                @else
                                Rp. {{number_format($p->pivot->price_item * $p->pivot->quantity, 0, ',', '.')}}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <!--<td colspan="5" align="right"><b>Voucher Discount</b> <small>
                                @if($order->id_voucher !=NULL)
                                {{($order->vouchers['description'])}}
                                @endif
                            </small> <b>:</b></td>
                            <td align="right">
                                @if(($order->id_voucher !=NULL)&&($order->vouchers['type'] == 1))
                                <b>{{$order->vouchers->discount_amount}}%</b>
                                @elseif(($order->id_voucher !=NULL)&&($order->vouchers['type'] == 2))
                                <b>{{number_format($order->vouchers->discount_amount, 0, ',', '.')}}</b>
                                @else
                                <b>0</b>
                                @endif
                            </td>-->
                        </tr>
                        <tr>
                            @php
                                $pirce_r = \App\order_product::where('order_id',$order->id)
                                ->whereNull('group_id')
                                ->whereNull('paket_id')
                                ->whereNull('bonus_cat')
                                ->sum(\DB::raw('price_item * quantity'));
                            @endphp
                            <td colspan="3" align="right" width="85%"><b>Total Price :</b></td>
                            <td align="right"><b>Rp. {{number_format($pirce_r, 0, ',', '.')}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
        
        @if(count( $paket_list) > 0)
            @foreach($paket_list as $paket)
                <div class="form-group">
                    
                    @php
                        $paket_name =\App\Paket::where('id',$paket->paket_id)
                                    ->first();
                        $group_name =\App\Group::where('id',$paket->group_id)
                                    ->first();           
                    @endphp
                    <table width="100%" class="table table-hover">
                        <thead>
                            <th width="50%" style="padding-left:10px;"><small>* Product {{$paket_name->display_name}} - {{$group_name->display_name}}</small></th>
                            <th width="" style="padding-left:10px;"><small>Quantity </small> </th>
                            <th width="" style="padding-left:10px;"><small>Price</small> </th>
                            <th width="" class="text-right"><small>Sub Total</small></th>
                        </thead>
                        <tbody>
                            @php
                                $cek_paket=\DB::table('order_product')
                                            ->join('products','products.id','=','order_product.product_id')
                                            ->where('order_id',$order->id)
                                            ->where('paket_id',$paket->paket_id)
                                            ->where('group_id',$paket->group_id)
                                            ->orderBy('bonus_cat','ASC')
                                            ->get();
                            @endphp
                            @foreach($cek_paket as $p)
                            <tr>
                                <td style="padding-top:10px;">
                                    @if($p->bonus_cat == NULL)
                                        {{$p->Product_name}}
                                    @else
                                        {{$p->Product_name}} (<small><b>PRODUCT BONUS</b></small>)
                                    @endif
                                </td>
                                <td style="padding-top:5px;">{{$p->quantity}}</td>
                                <td style="padding-top:5px;">
                                    @if($p->bonus_cat == NULL)
                                    Rp. {{number_format($p->price_item, 0, ',', '.')}}
                                    @endif
                                </td>
                                <td align="right">
                                    @if($p->bonus_cat == NULL)
                                        @if(($p->discount_item != NULL) && ($p->discount_item > 0))
                                            Rp. {{number_format($p->price_item_promo * $p->quantity, 0, ',', '.')}}
                                        @else
                                            Rp. {{number_format($p->price_item * $p->quantity, 0, ',', '.')}}
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            
                            <tr>
                                <td colspan="3" align="right" width="85%"><b>Total Price :</b></td>
                                @php
                                    $pkt_pirce = \App\order_product::where('order_id',$order->id)
                                    ->where('group_id',$paket->group_id)
                                    ->where('paket_id',$paket->paket_id)
                                    ->whereNull('bonus_cat')
                                    ->sum(\DB::raw('price_item * quantity'));
                                @endphp
                                <td align="right"><b>Rp. {{number_format($pkt_pirce, 0, ',', '.')}}</b></td>
                            </tr>
                            
                        .</tbody>
                    </table>

                </div>
            @endforeach
        @endif
        <div style="margin-top:-20px;">
            <table width="100%" class="table table-hover">
                <thead>
                    <th width="85%" class="text-right">Grand Total :</th>
                    <th width="" class="text-right">Rp. {{number_format($order->total_price, 0, ',', '.')}}</th>
                </thead>
            </table>
        </div>
       
        <label class="form-label">Status</label>
        <div class="form-group">
            <input type="radio" value="SUBMIT" name="status" id="SUBMIT" {{$order->status == 'SUBMIT' ? 'checked' : ''}}>
            <label for="SUBMIT">SUBMIT</label>
            &nbsp;
            <input type="radio" value="PROCESS" name="status" id="PROCESS" {{$order->status == 'PROCESS' ? 'checked' : ''}}>
            <label for="PROCESS">PROCESS</label>
            &nbsp;
            <input type="radio" value="FINISH" name="status" id="FINISH" {{$order->status == 'FINISH' ? 'checked' : ''}}>
            <label for="FINISH">FINISH</label>
            &nbsp;
            <input type="radio" value="CANCEL" name="status" id="CANCEL" {{$order->status == 'CANCEL' ? 'checked' : ''}}>
            <label for="CANCEL">CANCEL</label>
        </div>

        <input type="submit" class="btn btn-primary waves-effect" value="UPDATE" {{\Auth::user()->roles == 'SUPERVISOR' ? 'disabled' : ''}}>
        
    </form>
    <!-- #END#  -->		

@endsection

