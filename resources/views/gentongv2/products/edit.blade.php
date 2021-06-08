@extends('layouts.master')
@section('title') Edit Product @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('products.update',[$product->id])}}">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="Product_name" autocomplete="off" required value="{{$product->Product_name}}">
                <label class="form-label">Product Name</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" value="{{$product->slug}}" name="slug" autocomplete="off" required>
                <label class="form-label">Slug</label>
            </div>
        </div>
        
        <div class="form-group">
            <div class="form-line">
                <textarea name="description" rows="4" class="form-control no-resize" placeholder="Description" autocomplete="off" required>{{$product->description}}</textarea>
            </div>
        </div>

        <h2 class="card-inside-title">Categories</h2>
        <select name="categories"  id="categories" class="form-control"></select>
        <br>
        <h2 class="card-inside-title">Product Image</h2>
        <div class="form-group">
         <div class="form-line">
            @if($product->image)
            <img src="{{asset('storage/'.$product->image)}}" width="120px"/>
            @else
            No Image
            @endif
             <input type="file" name="image" class="form-control" id="image" autocomplete="off">
            </div>
        </div>

        
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="price" autocomplete="off" value="{{$product->price}}" required/>
                <label class="form-label">Product Price (IDR)</label>
            </div>
        </div>
        @if($product->discount > 0)
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="price_promo" autocomplete="off" value="{{$product->price_promo}}" readonly required/>
                <label class="form-label">Product Price Promo (IDR)</label>
            </div>
        </div>
        @endif
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="discount" autocomplete="off" value="{{$product->discount}}" required/>
                <label class="form-label">Discount ( % )</label>
            </div>
        </div>
            
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="stock" min="0" autocomplete="off" value="{{$product->stock}}" required>
                <label class="form-label">Product Stock</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="low_stock_treshold" min="0" value="{{$product->low_stock_treshold}}" autocomplete="off" required>
                <label class="form-label">Low Stock Treshold</label>
            </div>
        </div>
        
        <h2 class="card-inside-title">Make Top Product</h2>
        <div class="form-group">
            <input type="checkbox" name="top_product" id="top_product" value="1"  {{$product->top_product == '1' ? 'checked' : ''}}>
			<label for="top_product">Top Product</label>
		</div>

        <h2 class="card-inside-title">Status</h2>
        <div class="form-group">
            <input type="radio" value="PUBLISH" name="status" id="PUBLISH" {{$product->status == 'PUBLISH' ? 'checked' : ''}}>
            <label for="PUBLISH">PUBLISH</label>
                            &nbsp;
            <input type="radio" value="DRAFT" name="status" id="DRAFT" {{$product->status == 'DRAFT' ? 'checked' : ''}}>
            <label for="DRAFT">DRAFT</label>
        </div>

        <button class="btn btn-primary waves-effect" value="PUBLISH" type="submit">UPDATE</button>
        <!--<a href="{{URL::previous()}}" class="btn btn-danger waves-effect" >CANCEL</a>-->
        
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $('#categories').select2({
      placeholder: 'Select an item',
      ajax: {
        url: '{{URL::to('/ajax/categories/search')}}',
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                        id: item.id,
                        text: item.name
                      
                  }
              })
          };
        }
        
      }
    });

    var categories = {!! $product->categories !!}
    categories.forEach(function(category){
    var option = new Option(category.name, category.id, true, true);
    $('#categories').append(option).trigger('change');
    });
</script>

@endsection