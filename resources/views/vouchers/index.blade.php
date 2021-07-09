@extends('layouts.master')
@section('title') Vouchers List @endsection
@section('content')
@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif

<form action="{{route('vouchers.index', $client_slug)}}">
	<div class="row">
		<!--
		<div class="col-md-3">
			<div class="input-group input-group-sm">
        		<div class="form-line">
	            	<input type="text" class="form-control" name="keyword" value="{{Request::get('keyword')}}" placeholder="Filter by product name" autocomplete="off" />
	    		</div>
	        </div>
		</div>
		<div class="col-md-2">
			<input type="submit" class="btn bg-blue pull-left" value="Filter">
		</div>
		-->
		<div class="col-md-4">
			<ul class="nav nav-tabs tab-col-pink pull-left" >
				<li role="presentation" class="{{ Request::path() == 'vouchers' ? 'active' : ''}}">
					<a href="{{route('vouchers.index', $client_slug)}}" aria-expanded="true" >All</a>
				</li>
				<li role="presentation" class="">
					<a href="{{route('vouchers.trash', $client_slug)}}">TRUSH</a>
				</li>
			</ul>
		</div>
		
		<div class="col-md-8">
			<a href="{{route('vouchers.create', $client_slug)}}" class="btn btn-success pull-right">Create Voucher</a>
		</div>
		
	</div>
</form>
<hr>	
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>Voucher Code</th>
				<th>Voucher Name</th>
				<th>Description</th>
				<th width="1%">Total Used</th>
				<th width="1%">Max Usages</th>
				<th width="1%">Type</th>
				<th >Amount</th>
				<th width="1%">%</th>
				<th>Exp At</th>
				<th width="1%">Status</th>
				<th width="15%">Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($vouchers as $v)
			<tr>
				<td>{{$v->code}}</td>
				<td>{{$v->name}}</td>
				<td>{{$v->description}}</td>
				<td>{{$v->uses}}</td>
				<td>{{$v->max_uses}}</td>
				<td>@if($v->type == 1)
					Percentage
					@elseif($v->type == 2)
					Flat
					@endif
				</td>
				@if($v->type == 1)
					<td>----</td>
					<td>{{$v->discount_amount}}</td>
				@elseif($v->type == 2)
					<td>{{number_format($v->discount_amount)}}</td>
					<td>----</td>
				@endif
				<td>{{date("Y-M-d", strtotime($v->expires_at))}}</td>
				<td>
					@php
					$max_usage = $v->max_uses;
					$cur_date = date('Y-m-d');
					$exp_date = date("Y-m-d", strtotime($v->expires_at));
					if($v->uses >= $max_usage)
					{
						echo '<span class="badge bg-yellow text-white">FULL USED</span>';
					}
					elseif($cur_date > $exp_date){
						echo '<span class="badge bg-red text-white">EXPIRED</span>';
					}
					else
					{
						echo '<span class="badge bg-green text-white">ACTIVE</span>';
					}
					@endphp
				</td>
				<td>
					<a class="btn btn-info btn-xs" href="{{route('vouchers.edit',[$v->id, $client_slug])}}" style="margin-bottom:5px;"><i class="material-icons">edit</i></a>&nbsp;
					@if($v->uses !== NULL)
					<button class="btn btn-danger btn-xs" disabled><i class="material-icons">delete</i></button>
					@else
					<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$v->id}}"><i class="material-icons">delete</i></button>
					@endif
					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$v->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete Voucher</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete this voucher ..? 
		                        </div>
		                        <div class="modal-footer">
		                        	<form action="{{route('vouchers.destroy',[$v->id, $client_slug])}}" method="POST">
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