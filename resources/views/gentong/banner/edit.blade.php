@extends($client_slug.'.layouts.master')
@section('title') Edit Banner Slide @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('banner.update',[$banner_edit->id, $client_slug])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" value="{{$banner_edit->name}}" name="name" autocomplete="off" required>
                <label class="form-label">Name</label>
            </div>
        </div>

        <!--
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" value="{{$banner_edit->slug}}" name="slug" autocomplete="off" required>
                <label class="form-label">Slug</label>
            </div>
        </div>
        -->
        <h2 class="card-inside-title">Image</h2>
        <div class="form-group">
         <div class="form-line">
            @if($banner_edit->image)
            <img src="{{asset('storage/'.$banner_edit->image)}}" width="120px"/>
            @else
            No Image
            @endif
            <input type="file" name="image" class="form-control" id="avatar" autocomplete="off">
            </div>
        </div>

        <button class="btn btn-primary waves-effect" type="submit">EDIT</button>&nbsp;
        <a href="{{route('banner.index', $client_slug)}}" class="btn bg-deep-orange waves-effect" >&nbsp;CLOSE&nbsp;</a>
    </form>

    <!-- #END#  -->		

@endsection