@extends($client_slug.'.layouts.master')
@section('title') Banner Slide List @endsection
@section('content')

@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif

<form action="{{route('banner.index', $client_slug)}}">
	<div class="row">
		<!--
		<div class="col-md-4">
			<div class="input-group input-group-sm">
        		<div class="form-line">
				<input type="text" class="form-control" name="name" value="{{Request::get('name')}}"  placeholder="Filter berdasarkan nama" autocomplete="off" />
	    		</div>
				<span class="input-group-addon">
					<input type="submit" class="btn bg-blue" value="Filter">
				</span>
			</div>
		</div>
		-->
		<div class="col-md-4">
			<ul class="nav nav-tabs tab-col-pink pull-left" >
				<li role="presentation" class="active">
					<a href="{{route('banner.index', $client_slug)}}" aria-expanded="true" >All</a>
				</li>
				<li role="presentation" class="">
					<a href="{{route('banner.trash', $client_slug)}}" >TRUSH</a>
				</li>
			</ul>
		</div>		
		<div class="col-md-8">
			<a href="{{route('banner.create', $client_slug)}}" class="btn btn-success pull-right">Create Banner Slide</a>
		</div>
	</div>
</form>
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>No</th>
				<th>Name</th>
				<th>Image</th>
				<th width="20%">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($banner as $c)
			<?php $no++;?>
			<tr>
				<td>{{$no}}</td>
				<td>{{$c->name}}</td>
				<td>@if($c->image)
					<img src="{{asset('storage/'.$c->image)}}" width="50px" height="50px" />
					@else
					N/A
					@endif
				</td>
				<td>
					<a class="btn btn-info btn-xs" href="{{route('banner.edit',[$c->id, $client_slug])}}"><i class="material-icons">edit</i></a>&nbsp;
					<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$c->id}}"><i class="material-icons">delete</i></button>&nbsp;
					<button type="button" class="btn bg-grey waves-effect" data-toggle="modal" data-target="#detailModal{{$c->id}}">Detail</button>

					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$c->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete Slide Banner</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete this Image ..? 
		                        </div>
		                        <div class="modal-footer">
		                        	<form action="{{route('banner.destroy',[$c->id, $client_slug])}}" method="POST">
										@csrf
										<input type="hidden" name="_method" value="DELETE">
										<button type="submit" class="btn btn-link waves-effect">Delete</button>
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
									</form>
		                        </div>
		                    </div>
		                </div>
		            </div>
					
					<!-- Modal Detail -->
		            <div class="modal fade" id="detailModal{{$c->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog" role="document">
		                    <div class="modal-content modal-col-indigo">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="detailModalLabel">Detail Slide Banner</h4>
		                        </div>
		                        <div class="modal-body">
		                           <b>Banner Slide Name:</b>
		                           <br/>
		                           {{$c->name}}
		                           <br/>
		                           <br/>
		                           @if($c->image)
		                           <img src="{{asset('storage/'.$c->image)}}" width="128px"/>
		                           @else
		                           No Image
								   @endif
								   <!--
		                           <br/>
		                           <br/>
		                           <b>Category Slug:</b>
		                           <br/>
		                           {{$c->slug}}
		                           -->
		                        </div>
		                        <div class="modal-footer">
		                        	<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
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
@endsection