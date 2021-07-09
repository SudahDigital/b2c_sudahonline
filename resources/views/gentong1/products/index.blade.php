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
			<ul class="nav nav-tabs tab-col-pink pull-left" >
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
				<li role="presentation" class="">
					<a href="{{route('products.trash', $client_slug)}}" >TRUSH</a>
				</li>
			</ul>
		</div>
		<div class="col-md-6">&nbsp;</div>
		<div class="col-md-12">
			<a href="{{route('products.import_products', $client_slug)}}" class="btn btn-success ">Import Excel (<small>Update Stock</small>) </a>&nbsp;
			<a href="{{route('products.export_all', $client_slug)}}" class="btn btn-success ">Export Excel (<small>Products Stock</small>)</a>&nbsp;
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
				<th width="25%">Action</th>
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
					@if($p->discount > 0)
					<del>{{number_format($p->price)}}</del><br>
					{{number_format($p->price_promo)}}
					@else
					{{number_format($p->price)}}
					@endif
				</td>
				<td>
					@if($p->status=="DRAFT")
					<span class="badge bg-dark text-white">{{$p->status}}</span>
						@else
					<span class="badge bg-green">{{$p->status}}</span>
					@endif

					@if($p->top_product==1)
					<span class="badge bg-purple text-white">Top Product</span>
					@else
					@endif

					@if($p->discount > 0)
					<span class="badge bg-orange text-white">{{$p->discount}}% OFF</span>
					@else
					@endif
				</td>
				<td>
					<a class="btn btn-info btn-xs" href="{{route('products.edit',[$p->id, $client_slug])}}"><i class="material-icons">edit</i></a>&nbsp;
					<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$p->id}}"><i class="material-icons">delete</i></button>&nbsp;
					<button type="button" class="btn bg-grey waves-effect" data-toggle="modal" data-target="#detailModal{{$p->id}}" style="padding: 4px 8px;"><small>Detail</small></button>

					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$p->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete Product</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete this product ..? 
		                        </div>
		                        <div class="modal-footer">
		                        	<form action="{{route('products.destroy',[$p->id, $client_slug])}}" method="POST">
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
		            <div class="modal fade" id="detailModal{{$p->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog" role="document">
		                    <div class="modal-content modal-col-indigo">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="detailModalLabel">Detail Product</h4>
		                        </div>
		                        <div class="modal-body">
									@if($p->image)
									<img src="{{asset('storage/'.$p->image)}}" width="128px"/>
									@else
									No Image
									@endif
								   <br/><br/>
		                           <b>Product Name:</b>
		                           <br/>
		                           {{$p->Product_name}}
		                           <br/><br/>
		                           <b>Product Description:</b>
		                           <br/>
		                           {{$p->description}}
		                           <br/><br/>
		                           <b>Category:</b>
		                           <br/>
								   @foreach($p->categories as $category)
								   
										{{$category->name}}
								   
									@endforeach
		                           <br/><br/>
		                           <b>Stock:</b>
		                           <br/>
		                           {{$p->stock}}
		                           <br/><br/>
		                           <b>Price:</b>
		                           <br/>
								   {{number_format($p->price)}}
								   <br/><br/>
		                           <b>Status</b>
		                           <br/>
		                           	@if($p->status=="DRAFT")
										<span class="badge bg-dark text-white">{{$p->status}}</span>
									@else
										<span class="badge badge-success">{{$p->status}}</span>
									@endif
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