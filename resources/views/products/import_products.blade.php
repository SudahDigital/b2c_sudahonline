@extends('layouts.master')
@section('title') Import Product @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
    @endif
    @if(session('error'))
		<div class="alert alert-danger">
			{{session('error')}}
		</div>
	@endif


	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('products.import_data')}}">
    	@csrf
        
        <h2 class="card-inside-title">File(.xls, .xlsx)</h2>
        <div class="form-group">
            <div class="form-line">
             <input type="file" name="file" class="form-control" id="file" autocomplete="off" required>
            </div>
            <label id="name-error" class="error" for="file">{{ $errors->first('file') }}</label>
        </div>
        
        <button class="btn btn-primary waves-effect" name="save_action" value="IMPORT" type="submit">UPLOAD</button>
        <a href="{{URL::previous()}}" class="btn btn-danger waves-effect" >CANCEL</a>
    </form>
    <!-- #END#  -->		

@endsection

