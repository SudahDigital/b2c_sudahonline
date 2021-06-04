@extends('layouts.master')
@section('title') Create Product @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('products.store')}}">
    	@csrf
        <div class="form-group form-float">
            <div class="form-line" id="code_">
                <input type="text" class="form-control" id="code"  name="code" autocomplete="off" required>
                <label class="form-label">Product Code</label>
            </div>
            <label id="name-error" class=""></label>
            <small class=""></small>
        </div>

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
                <label class="form-label">Product Price /Box (IDR)</label>
            </div>
        </div>

        <!--
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="discount" autocomplete="off" min="0" value="0.00" required/>
                <label class="form-label">Discount ( % )</label>
            </div>
        </div>
        -->

        <input type="hidden" class="form-control" name="discount" autocomplete="off" min="0" value="0.00" required/>
        
        @if($stock_status->stock_status == 'ON')
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" onKeyUp="test_fn(this.value)" class="form-control" id="stock" name="stock" min="0" value="0" autocomplete="off" maxlength="9" required>
                <label class="form-label">Product Stock (Box)</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" id="low_stock" onKeyUp="test_fn_1(this.value)" class="form-control" name="low_stock_treshold" min="0" value="0" autocomplete="off" required maxlength="9">
                <label class="form-label">Low Stock Treshold</label>
            </div>
        </div>
        @else
        <input type="hidden" class="form-control" name="stock"  value="0" required/>
        <input type="hidden" class="form-control" name="low_stock_treshold"  value="0" required/>
        @endif
        
        <h2 class="card-inside-title">Make Top Product</h2>
        <div class="form-group">
            <input type="checkbox" name="top_product" id="top_product" value="1">
			<label for="top_product">Top Product</label>
		</div>
        
        <!--
        <input type="hidden" name="top_product" id="top_product" value="0">
        -->
        <button class="btn btn-primary waves-effect" name="save_action" value="PUBLISH" type="submit">PUBLISH</button>
        <button class="btn btn-secondary waves-effect" name="save_action" value="DRAFT" type="submit">SAVE AS DRAfT</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script>
    $("#code").on({
        keydown: function(e) {
        if (e.which === 32)
            return false;
        },
        keyup: function(){
        this.value = this.value.toUpperCase();
        },
        change: function() {
            this.value = this.value.replace(/\s/g, "");
            
        }
    });

    $('document').ready(function(){
        $('#code, .btn').on('keyup', function(){
        var code = $('#code').val();
            $.ajax({
                url: '{{URL::to('/ajax/products/code/search')}}',
                type: 'get',
                data: {
                    'code' : code,
                },
                success: function(response){
                    if (response == 'taken' && code !="" ) {
                    $('#code_').addClass("focused error");
                    $('#code_').siblings("label").addClass("error").text('Sorry... Product code Already Exists');
                    $('#code_').siblings("small").text('');
                    $('#save').prop('disabled', true);
                    }else if (response == 'not_taken' && code !="") {
                    $('#code_').addClass("");
                    $('#code_').siblings("small").addClass("text-primary").text('Product code Available');
                    $('#code_').siblings("label").text('');
                    $('#save').prop('disabled', false);
                    }
                    else if(response == 'not_taken' && code ==""){
                        $('#code_').siblings("label").text('');
                        $('#code_').siblings("small").text('');
                    }
                }
            });
        });
    });

    //select2
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


    
    function test_fn(test_value){
        var test_value = test_value.replace(/[^0-9]+/g, "");
        document.getElementById("stock").value = "";
        document.getElementById("stock").value = test_value;
    }

    function test_fn_1(test_value){
        var test_value = test_value.replace(/[^0-9]+/g, "");
        document.getElementById("low_stock").value = "";
        document.getElementById("low_stock").value = test_value;
    }
    </script>

@endsection