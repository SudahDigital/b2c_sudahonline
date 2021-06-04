@extends('layouts.master')
@section('title') Group Paket List @endsection
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
<form action="{{route('products.index')}}">
	<div class="row">
		<div class="col-md-12">
			<a href="{{route('groups.create')}}" class="btn bg-cyan pull-right">Create Group Paket</a>
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
				<th>Group Image</th>
				<th>Display Name</th>
				<th>Product Group</th>
				<th>Status</th>
				<th width="25%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($groups as $p)
			<?php $no++;?>
			<tr>
				<td>{{$no}}</td>
				<td>{{$p->group_name}}</td>
				<td>@if($p->group_image)
					<img src="{{asset('storage/'.$p->group_image)}}" width="50px" height="50px" />
					@else
					N/A
					@endif
				</td>
				<td>{{$p->display_name}}</td>
				<td align="left">
					<ul style="margin-left: -25px;">
						@if(($p->status == 'ACTIVE')&&($p->item_active->count() > 0))
							@foreach($p->item_active as $p_group)
								<li><small>{{$p_group->Product_name}}</small></li>
							@endforeach
						@else
							--No item active--
						@endif
					</ul>
				</td>
				<td>
					@if($p->status=="INACTIVE")
					<span class="badge bg-dark text-white">{{$p->status}}</span>
						@else
					<span class="badge bg-green">{{$p->status}}</span>
					@endif

				</td>
				<td>
					<a class="btn btn-info btn-xs" href="{{route('groups.edit',[$p->id])}}">Detail</a>
					<button type="button" class="btn bg-{{$p->status == 'ACTIVE' ? 'orange' : 'cyan'}} btn-xs" data-toggle="modal" data-target="#activeModal{{$p->id}}"><small>{{$p->status == 'ACTIVE' ? 'DEACTIVATE' : 'ACTIVATE'}}</small></button>
					<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$p->id}}"><i class="material-icons">delete</i></button>
					<!-- Modal deactivate -->
					<div class="modal fade" id="activeModal{{$p->id}}" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-sm" role="document">
							<div class="modal-content modal-col-{{$p->status == 'ACTIVE' ? 'orange' : 'cyan'}}">
								<div class="modal-header">
									<h4 class="modal-title">{{$p->status == 'ACTIVE' ? 'Deactivate Group' : 'Activate Group'}}</h4>
								</div>
								<div class="modal-body">
									{{$p->status == 'ACTIVE' ? 'Deactivate this group ?' : 'Activate this group ?'}}
								</div>
								<div class="modal-footer">
									<form action="{{route('groups.edit_status')}}" method="POST">
										@csrf
										<input type="hidden" name="{{$p->status == 'ACTIVE' ? 'deactivate_id' : 'activate_id'}}" value="{{$p->id}}">
										<button type="submit" name="save_action" value="{{$p->status == 'ACTIVE' ? 'DEACTIVATE' : 'ACTIVATE'}}" class="btn btn-link waves-effect">{{$p->status == 'ACTIVE' ? 'Deactivate' : 'Activate'}}</button>
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$p->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete Group</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete this group
								</div>
		                        <div class="modal-footer">
		                        	<form action="{{route('groups.destroy',[$p->id])}}" method="POST">
										@csrf
										<input type="hidden" name="_method" value="DELETE">
										<button type="submit" class="btn btn-link waves-effect">Delete</button>
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
									</form>
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
