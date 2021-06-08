@extends('layouts.master')
@section('title') Edit Order @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" action="{{route('order_edit_update')}}">
        @csrf
        
        <!--
        <div class="form-group form-float">
            <div class="form-line">
                <label class="form-label">Invoice number</label>
                <input type="text" class="form-control" autocomplete="off" value="" disabled>
            </div>
        </div>
        -->
        <input type="hidden" name="order_id" value="{{$order->id}}">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control"  name="username" autocomplete="off"  value="{{$order->username}}" required>
                <label class="form-label">User Name</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control"  name="email" autocomplete="off"  value="{{$order->email}}" required>
                <label class="form-label">Email</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control"  name="address" autocomplete="off"  value="{{$order->address}}" required>
                <label class="form-label">Address</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="phone" minlength="10" maxlength="13" autocomplete="off" value="{{$order->phone}}" required>
                <label class="form-label">Phone </label>
            </div>
            <div class="help-info">Min.10, Max. 13 Characters</div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control"  autocomplete="off"  value="{{$order->created_at}}" disabled>
                <label class="form-label">Order date</label>
            </div>
        </div>

        <div class="form-group">
        <label class="form-label">Products Order</label>
            
                <table width="100%" class="table table-hover">
                    <thead>
                        <th width="40%" style="padding-left:10px;"><small>Product Name</small></th>
                        <th width="60%" style="padding-left:10px;"><small>Quantity</small> </th>
                    </thead>
                    @foreach($order->products as $p)
                    <tr>
                        <td style="padding-top:10px;">
                            <input type="hidden" name="id[]" value="{{$p->pivot->id}}">
                            <select name="product_id[]"  class="products form-control">
                                @foreach($products as $pro)
                                @if($pro->id == $p->pivot->product_id)
                                    <option value="{{$pro->id}}" selected="">{{$pro->description}}</option>
                                @else
                                    <option value="{{$pro->id}}">{{$pro->description}}</option>
                                @endif
                                @endforeach
                            </select>

                            
                        </td>
                        <td style="padding-top:5px;">
                            <div class="form-line">
                                <input style="padding:10px;" type="number" name="quantity[]" min="1" class="form-control" value="{{$p->pivot->quantity}}">
                            </div>
                        </td>
                    </tr>
                    @endforeach
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
        <input type="hidden" name="id_voucher" value="{{$order->id_voucher}}">
        <input type="submit" class="btn btn-primary waves-effect" value="UPDATE">
        
    </form>
    <!-- #END#  -->		

@endsection
@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $('.products').select2({});

    
</script>
@endsection
