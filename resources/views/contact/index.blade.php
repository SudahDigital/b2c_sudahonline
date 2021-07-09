@extends('layouts.master')
@section('title') Contact List @endsection
@section('content')

@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif

<form action="{{route('contacts.index', $client_slug)}}">
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
					<a href="{{route('contacts.index', $client_slug)}}" aria-expanded="true" >All</a>
				</li>
			</ul>
		</div>		
		<!-- <div class="col-md-8">
			<a href="{{route('banner.create', $client_slug)}}" class="btn btn-success pull-right">Create Banner Slide</a>
		</div> -->
	</div>
</form>
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>No</th>
				<th>Barcode Image</th>
				<th>Contact Number</th>
				<th>Whatsapp Number</th>
				<th>Contact Email</th>
				<th width="20%">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($contact as $c)
			<?php $no++;?>
			<tr>
				<td>{{$no}}</td>
				<td>@if($c->barcode_image)
					<img src="{{asset('assets/image/'.$client_slug.'/'.$c->barcode_image)}}" width="50px" height="50px" />
					@else
					N/A
					@endif
				</td>
				<td>{{$c->client_number_contact}}</td>
				<td>{{$c->client_number_wa }}</td>
				<td>{{$c->client_email }}</td>
				<td>
					<a class="btn btn-info btn-xs" href="{{route('contacts.edit',[$c->id, $client_slug])}}"><i class="material-icons">edit</i></a>&nbsp;
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
		                            <h4 class="modal-title" id="detailModalLabel">Detail Contact</h4>
		                        </div>
		                        <div class="modal-body">
		                           <b>Contact Number:</b>
		                           <br/>
		                           {{$c->client_number_contact}}
		                           <br/>
		                           <b>Whatsapp Number:</b>
		                           <br/>
		                           {{$c->client_number_wa }}
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