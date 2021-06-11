@extends($client_slug.'.layouts.master')
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
				<li role="presentation" class="active">
					<a href="{{route('products.low_stock', $client_slug)}}">LOW STOCK</a>
				</li>
				<li role="presentation">
					<a href="{{route('products.trash', $client_slug)}}">TRUSH</a>
				</li>
			</ul>
		</div>
		<div class="col-md-6">
			&nbsp;
		</div>
		<div class="col-md-12">
			<a href="{{route('products.import_products', $client_slug)}}" class="btn btn-success ">Import Excel (<small>Update Stock</small>) </a>&nbsp;
			<a href="{{route('products.export_lowstock', $client_slug)}}" class="btn btn-success ">Export Excel (<small>Products Stock</small>)</a>&nbsp;
			<a href="{{route('products.edit_stock', $client_slug)}}" class="btn bg-cyan">Update Stock</a>
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
				<th width="5%">Action</th>
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
					<a class="btn btn-info btn-xs" href="{{route('products.edit',[$p->id, $client_slug])}}"><i class="material-icons">edit</i></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection