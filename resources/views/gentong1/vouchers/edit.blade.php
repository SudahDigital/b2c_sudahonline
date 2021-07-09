@extends($client_slug.'.layouts.master')
@section('title') Edit Voucher @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Edit -->
    <form id="form_validation" method="POST"  action="{{route('vouchers.update',[$voucher->id, $client_slug])}}">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="name" autocomplete="off" 
                value="{{$voucher->name}}"  {{$voucher->uses !== NULL ? 'readonly' : ''}} required>
                <label class="form-label">Voucher Name</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line" id="code_">
                <input type="text" class="form-control" id="code" name="code" value="{{$voucher->code}}" autocomplete="off" required readonly>
                <label class="form-label">Voucher Code</label>
            </div>
        </div>

        <div class="form-group">
            <div class="form-line">
                <textarea name="description" rows="4" class="form-control no-resize" placeholder="Description" 
                autocomplete="off" required {{$voucher->uses !== NULL ? 'readonly' : ''}}>{{$voucher->description}}</textarea>
            </div>
        </div>
        
        <h2 class="card-inside-title">Voucher Type</h2>
        <div class="form-group">
            @if($voucher->uses !== NULL)
            <input type="hidden" value="{{$voucher->type}}" name="type">
            @endif
            <input 
            type="radio"
            {{$voucher->type == 1 ? "checked" : ""}} 
            name="{{$voucher->uses !== NULL ? '' : 'type'}}" 
            class="form-control {{$errors->first('type') ? "is-invalid" : "" }}"
            id="persentage" 
            value="1" {{$voucher->uses !== NULL ? 'disabled' : ''}}> 
            <label for="persentage">Percentage</label>

            <input 
            type="radio"
            {{$voucher->type == 2 ? "checked" : ""}} 
            name="{{$voucher->uses !== NULL ? '' : 'type'}}" 
            class="form-control {{$errors->first('type') ? "is-invalid" : "" }}"
            id="flat" 
            value="2" {{$voucher->uses !== NULL ? 'disabled' : ''}}> 
            <label for="flat">Flat</label>

            <div class="invalid-feedback">
                {{$errors->first('type')}}
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="discount_amount" 
                autocomplete="off" min="0" value="{{$voucher->discount_amount}}" 
                {{$voucher->uses !== NULL ? 'readonly' : ''}} required/>
                <label class="form-label">Amount</label>
            </div>
        </div>

        <h2 class="card-inside-title">Expires</h2>
        <div class="form-group">
            <div class="form-line" id="bs_datepicker_container">
                <input type="text" id="datepicker" name="expires_at" class="form-control" 
                value="{{date("Y-m-d", strtotime($voucher->expires_at))}}" placeholder="Please choose a date...">
            </div>
        </div>
        
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" id="max_uses" name="max_uses" value="{{$voucher->max_uses}}" autocomplete="off" required>
                <label class="form-label">Maximum Number Of Usages</label>
            </div>
        </div>

        <button class="btn btn-primary waves-effect" value="UPDATE" type="submit">UPDATE</button>
        <a href="{{route('vouchers.index', $client_slug)}}" class="btn btn-warning waves-effect" >CLOSE</a>
    </form>
    <!-- #END#  -->		

@endsection

