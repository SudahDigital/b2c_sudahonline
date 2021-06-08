@extends('layouts.master')
@section('title') User List @endsection
@section('content')
@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif

<form action="{{route('users.index')}}">
	<div class="row">
		<!--
		<div class="col-md-4">
			<div class="input-group input-group-sm">
        		<div class="form-line">
	            	<input type="text" class="form-control" name="keyword" value="{{Request::get('keyword')}}" placeholder="Filter berdasarkan email" autocomplete="off" />
	    		</div>
	        </div>
		</div>
		<div class="col-md-4">
			<input {{Request::get('status')=='ACTIVE' ? 'checked' : ''}} class="form-control" value="ACTIVE" name="status" type="radio" id="active"><label for="active">ACTIVE</label>
				&nbsp;&nbsp;
			<input {{Request::get('status')=='INACTIVE' ? 'checked' : ''}} class="form-control" value="INACTIVE" name="status" type="radio" id="inactive"><label for="inactive">INACTIVE</label>
				&nbsp;&nbsp;
			<input type="submit" class="btn bg-blue" value="Filter">
		</div>
		-->
		<div class="col-md-12">
			<a href="{{route('users.create')}}" class="btn btn-success pull-right">Create User</a>
		</div>
	</div>
</form>	
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>No</th>
				<th>Name</th>
				<th>Email</th>
				<th>Avatar</th>
				<th>Status</th>
				<th width="20%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($users as $u)
			<?php $no++;?>
			<tr>
				<td>{{$no}}</td>
				<td>{{$u->name}}</td>
				
				<td>{{$u->email}}</td>
				<td>@if($u->avatar)
					<img src="{{asset('storage/'.$u->avatar)}}" width="50px" height="50px" />
					@else
					N/A
					@endif
				</td>
				<td>
					@if(($u->status)=='ACTIVE')
						<span class="badge bg-green">{{$u->status}}</span>
					@else
						<span class="badge bg-red">{{$u->status}}</span>	
					@endif
				</td>
				<td>
					<a class="btn btn-info btn-xs" href="{{route('users.edit',[$u->id])}}"><i class="material-icons">edit</i></a>&nbsp;
					<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$u->id}}"><i class="material-icons">delete</i></button>&nbsp;
					<button type="button" class="btn bg-grey waves-effect" data-toggle="modal" data-target="#detailModal{{$u->id}}">Detail</button>

					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$u->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete User</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete this user permananetly..? 
		                        </div>
		                        <div class="modal-footer">
		                        	<form action="{{route('users.destroy',[$u->id])}}" method="POST">
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
		            <div class="modal fade" id="detailModal{{$u->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog" role="document">
		                    <div class="modal-content modal-col-indigo">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="detailModalLabel">Detail User</h4>
		                        </div>
		                        <div class="modal-body">
		                           <b>Name:</b>
		                           <br/>
		                           {{$u->name}}
		                           <br/>
		                           <br/>
		                           @if($u->avatar)
		                           <img src="{{asset('storage/'.$u->avatar)}}" width="128px"/>
		                           @else
		                           No Avatar
		                           @endif
		                           <br/>
		                           <br/>
		                           <b>UserName:</b>
		                           <br/>
		                           {{$u->email}}
		                           <br/>
		                           <br/>
		                           <b>Phone Number:</b>
		                           <br/>
		                           {{$u->phone}}
		                           <br/>
		                           <br/>
		                           <b>Address:</b>
		                           <br/>
		                           {{$u->address}}
		                           <br/>
		                           <br/>
		                           <b>Roles:</b>
		                           <br/>
		                           {{$u->roles}}
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