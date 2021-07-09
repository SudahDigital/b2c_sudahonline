@extends('layouts.master')
@section('title') Product List @endsection
@section('content')
@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif

<form action="{{route('products.index', $client_slug)}}">
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
		<div class="col-md-6">
			<ul class="nav nav-tabs tab-col-pink pull-left" role="tablist">
				<li role="presentation" class="{{Request::get('status') == NULL && Request::path() == 'products' ? 'active' : ''}}">
					<a href="{{route('products.index', $client_slug)}}" aria-expanded="true" >All</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'publish' ?'active' : '' }}">
					<a href="{{route('products.index', ['status' =>'publish', $client_slug])}}" >PUBLISH</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'draft' ?'active' : '' }}">
					<a href="{{route('products.index', ['status' =>'draft', $client_slug])}}">DRAFT</a>
				</li>
				<li role="presentation" class="">
					<a href="{{route('products.low_stock', $client_slug)}}">LOW STOCK</a>
				</li>
				<li role="presentation" class="active">
					<a href="{{route('products.trash', $client_slug)}}">TRUSH</a>
				</li>
			</ul>
		</div>
		<div class="col-md-6">&nbsp;</div>
		<div class="col-md-12">
			<a href="{{route('products.import_products', $client_slug)}}" class="btn btn-success ">Import Excel (<small>Update Products</small>) </a>&nbsp;
			<a href="{{route('products.export_all', $client_slug)}}" class="btn btn-success ">Export Excel</a>&nbsp;
			<a href="{{route('products.create', $client_slug)}}" class="btn bg-cyan">Create Product</a>
		</div>
	</div>
</form>	
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>No</th>
				<th>Product Image</th>
				<th>Product Name</th>
				<th>Descritption</th>
				<th>Category</th>
				<th>Stock</th>
				<th>Low Stock Treshold</th>
				<th>Price</th>
				<th>Status</th>
				<th width="20%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($products as $p)
			<?php $no++;?>
			<tr>
				<td>{{$no}}</td>
				<td>@if($p->image)
					<img src="{{asset('storage/'.$p->image)}}" width="50px" height="50px" />
					@else
					N/A
					@endif
				</td>
				<td>{{$p->Product_name}}</td>
				<td>{{$p->description}}</td>
				<td>
					@foreach($p->categories as $category)
						{{$category->name}}
					@endforeach
					
				</td>
				<td>
					{{$p->stock}}
				</td>
				<td>
					{{$p->low_stock_treshold}}
				</td>
				<td>
					{{$p->price}}
				</td>
				<td>
					@if($p->status=="DRAFT")
					<span class="badge bg-dark text-white">{{$p->status}}</span>
						@else
					<span class="badge bg-green">{{$p->status}}</span>
					@endif
				</td>
				<td>
					<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$p->id}}"><i class="material-icons">delete</i></button>&nbsp;
					<button type="button" class="btn bg-grey waves-effect" data-toggle="modal" data-target="#restoreModal{{$p->id}}">Restore</button>

					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$p->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete Product</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete permanent this product ..? 
		                        </div>
		                        <div class="modal-footer">
		                        	<form action="{{route('products.delete-permanent',[$p->id, $client_slug])}}" method="POST">
										@csrf
										<input type="hidden" name="_method" value="DELETE">
										<button type="submit" class="btn btn-link waves-effect">Delete</button>
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
									</form>
		                        </div>
		                    </div>
		                </div>
		            </div>

		           <!-- Modal Resotore -->
				   <div class="modal fade" id="restoreModal{{$p->id}}" tabindex="-1" role="dialog">
					<div class="modal-dialog modal-sm" role="document">
						<div class="modal-content modal-col-green">
							<div class="modal-header">
								<h4 class="modal-title" id="restoreModalLabel">Restore Product</h4>
							</div>
							<div class="modal-body">
							   Restore this product ..? 
							</div>
							<div class="modal-footer">
								
									<a href="{{route('products.restore', [$p->id, $client_slug])}}" class="btn bg-deep-orange">Restore</a>
									<button type="button" class="btn bg-deep-orange" data-dismiss="modal">Close</button>
								
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