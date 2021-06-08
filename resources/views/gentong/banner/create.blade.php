@extends('layouts.master')
@section('title') Create Banner Slide @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('banner.store')}}">
    	@csrf
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="name" autocomplete="off" required>
                <label class="form-label">Banner Name</label>
            </div>
        </div>
        
        <h2 class="card-inside-title">Banner Image</h2>
        <div class="form-group">
         <div class="form-line">
             <input type="file" name="image" class="form-control" id="image" autocomplete="off">
            </div>
        </div>
                        
        <button class="btn btn-primary waves-effect" type="submit">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection