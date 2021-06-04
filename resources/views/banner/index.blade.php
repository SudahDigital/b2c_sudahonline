@extends('layouts.master')
@section('title') Banner Slide List @endsection
@section('content')

@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif

<form action="{{route('banner.index')}}">
	<div class="row">
		
		<div class="col-md-4">
			<ul class="nav nav-tabs tab-col-pink pull-left" >
				<li role="presentation" class="active">
					<a href="{{route('banner.index')}}" aria-expanded="true" >All</a>
				</li>
				<li role="presentation" class="">
					<a href="{{route('banner.trash')}}" >TRUSH</a>
				</li>
			</ul>
		</div>		
		<div class="col-md-8">
			<a href="{{route('banner.create')}}" class="btn btn-success pull-right">Create Banner Slide</a>
		</div>
	</div>
</form>
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th width="1%">#</th>
				<th>Name</th>
				<th>Image</th>
				
				<th width="20%">Actions</th>
			</tr>
		</thead>
		<tbody id="tablecontents">
			<?php $no=0;?>
			@foreach($banner as $c)
			<?php $no++;?>
			<tr class="row1" data-id="{{ $c->id }}">
				<td><i class="fa fa-sort"></i></td>
				<td>{{$c->name}}</td>
				<td>@if($c->image)
					<img src="{{asset('storage/'.$c->image)}}" width="50px" height="50px" />
					@else
					N/A
					@endif
				</td>
				<td>
					<a class="btn btn-info btn-xs" href="{{route('banner.edit',[$c->id])}}"><i class="material-icons">edit</i></a>&nbsp;
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
		                        	<form action="{{route('banner.destroy',[$c->id])}}" method="POST">
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
@section('footer-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript">
	$(function () {
	  $( "#tablecontents" ).sortable({
		items: "tr",
		cursor: 'move',
		opacity: 0.6,
		update: function() {
			sendOrderToServer();
		}
	  });

	  function sendOrderToServer() {
		var order = [];
		var token = $('meta[name="csrf-token"]').attr('content');
		$('tr.row1').each(function(index,element) {
		  order.push({
			id: $(this).attr('data-id'),
			position: index+1
		  });
		});

		$.ajax({
		  type: "POST", 
		  dataType: "json", 
		  url: '{{URL::to('/ajax/post-sortable')}}',
			data: {
			posit: order,
			_token: token
		  },
		  success: function(response) {
			  if (response.status == "success") {
				console.log(response);
				} else {
				console.log(response);
			  }
			  
		  }
		});
	  }
	});
</script>
@endsection