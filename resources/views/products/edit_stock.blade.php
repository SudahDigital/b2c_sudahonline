@extends('layouts.master')
@section('title') Edit Stock @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('products.update_lowstock', $client_slug)}}">
    	@csrf
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="stock" min="0" value="0" autocomplete="off" required>
                <label class="form-label">Product Stock</label>
            </div>
        </div>

        <button class="btn btn-primary waves-effect" name="save_action" value="UPDATE_LOW_GLOBAL_STOOK" type="submit">UPDATE</button>
        <a href="{{URL::previous()}}" class="btn btn-danger waves-effect" >CANCEL</a>
    </form>
    <!-- #END#  -->		

@endsection

