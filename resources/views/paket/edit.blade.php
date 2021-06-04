@extends('layouts.master')
@section('title') Edit Paket @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('paket.update',[$pakets->id])}}">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group form-float">
            <div class="form-line" >
                <input type="text" class="form-control" value="{{$pakets->paket_name}}" readonly name="paket_name" autocomplete="off" required>
                <label class="form-label">Paket Name</label>
            </div>
        </div>
        <!--
        <h2 class="card-inside-title">Groups</h2>
        <select name="groups"  id="groups" class="form-control" required></select>
        <br>
        <br>
        -->
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{$pakets->display_name}}" class="form-control" name="display_name" autocomplete="off" required>
                <label class="form-label">Display Name</label>
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" value="{{$pakets->bonus_quantity}}" class="form-control" name="bonus_quantity" autocomplete="off" required>
                <label class="form-label">Bonus Quantity</label>
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" value="{{$pakets->purchase_quantity}}" name="purchase_quantity" autocomplete="off" required>
                <label class="form-label">Purchase Quantity</label>
            </div>
        </div>
        
        <button class="btn btn-primary waves-effect" value="UPDATE" type="submit">UPDATE</button>
        <!--<a href="{{URL::previous()}}" class="btn btn-danger waves-effect" >CANCEL</a>-->
        
    </form>
    <!-- #END#  -->		

@endsection

