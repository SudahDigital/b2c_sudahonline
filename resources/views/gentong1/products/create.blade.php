@extends($client_slug.'.layouts.master')
@section('title') Create Product @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('products.store', $client_slug)}}">
    	@csrf
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="Product_name" autocomplete="off" required>
                <label class="form-label">Product Name</label>
            </div>
        </div>
        
        <div class="form-group">
            <div class="form-line">
                <textarea name="description" rows="4" class="form-control no-resize" placeholder="Description" autocomplete="off" required></textarea>
            </div>
        </div>

        <h2 class="card-inside-title">Categories</h2>
         <input type="hidden" name="client_nm" id="client_nm" value="{{$client_slug}}">
        <select name="categories"  id="categories" class="form-control"></select>
        <br>
        <h2 class="card-inside-title">Product Image</h2>
        <div class="form-group">
         <div class="form-line">
             <input type="file" name="image" class="form-control" id="image" autocomplete="off">
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="price" autocomplete="off" required>
                <label class="form-label">Product Price (IDR)</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="discount" autocomplete="off" min="0" value="0.00" required/>
                <label class="form-label">Discount ( % )</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="stock" min="0" value="0" autocomplete="off" required>
                <label class="form-label">Product Stock</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="low_stock_treshold" min="0" value="0" autocomplete="off" required>
                <label class="form-label">Low Stock Treshold</label>
            </div>
        </div>

        <h2 class="card-inside-title">Make Top Product</h2>
        <div class="form-group">
            <input type="checkbox" name="top_product" id="top_product" value="1">
			<label for="top_product">Top Product</label>
		</div>
        
        <button class="btn btn-primary waves-effect" name="save_action" value="PUBLISH" type="submit">PUBLISH</button>
        <button class="btn btn-secondary waves-effect" name="save_action" value="DRAFT" type="submit">SAVE AS DRAfT</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    var client = $('#client_nm').val();
    $('#categories').select2({
      placeholder: 'Select an item',
      ajax: {
        // url: '{{URL::to('/ajax/categories/search')}}',
        url : '{{url("/ajax/search_categories")}}',
        data:{'client':client},
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
    </script>

@endsection