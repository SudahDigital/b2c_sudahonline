@extends('layouts.master')
@section('title') Create Group Paket @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('groups.store')}}">
    	@csrf

        <div class="form-group form-float">
            <div class="form-line" id="code_">
                <input type="text" class="form-control" id="code" name="group_name" autocomplete="off" required>
                <label class="form-label">Group Name</label>
            </div>
            <label id="name-error" class=""></label>
            <small class=""></small>
        </div>

        <h2 class="card-inside-title">Group Image</h2>
        <div class="form-group">
         <div class="form-line">
             <input type="file" name="group_image" class="form-control" id="group_image" autocomplete="off" required>
            </div>
        </div>
        
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="display_name" autocomplete="off" required>
                <label class="form-label">Display Name</label>
            </div>
        </div>
        <!--
        <div class="card">
            <div class="card-body">
                <table class="table" id="products_table">
                    <thead>
                        <tr>
                            <th>Product</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="product0">
                            <td>
                                <select name="products[]" id="sl0" class="products" style="width: 100%;">
                                   
                                </select>
                            </td>
                        </tr>
                        <tr id="product1"></tr>
                    </tbody>
                </table>
                <div class="col-md-12">
                    <button id="add_row" class="btn bg-light-green waves-effect">+ Add Row</button>
                    <button id='delete_row' class="pull-right btn btn-danger">- Delete Row</button>
                </div>
            </div>
            <div class="row">
            </div>
        </div>
        -->
        <label class="form-label">Product Group</label>
        <br>
        <br>
        <div class="form-group">
            <input type="checkbox" name="all_product" id="all_product" value="ALL_PRODUCT" onclick="checkstate()">
			<label for="all_product">All Product</label>
		   
            <select id="list_product" class="products" multiple="multiple" name="product_id[]" style="width: 100%;" required>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->Product_name }}
                    </option>
                @endforeach
            </select>
        </div>

       <button class="btn btn-primary" name="save_action" id="save" value="SAVE" type="submit" style="margin-top:20px;">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection
@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script>
    $(".products").select2({
        width: 'resolve' // need to override the changed default
    });

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
                url: '{{URL::to('/ajax/groups/search')}}',
                type: 'get',
                data: {
                    'code' : code,
                },
                success: function(response){
                    if (response == 'taken' && code !="" ) {
                    $('#code_').addClass("focused error");
                    $('#code_').siblings("label").addClass("error").text('Sorry... Group Name Already Exists');
                    $('#code_').siblings("small").text('');
                    $('#save').prop('disabled', true);
                    }else if (response == 'not_taken' && code !="") {
                    $('#code_').addClass("");
                    $('#code_').siblings("small").addClass("text-primary").text('Group Name Available');
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

    function checkstate() {
        document.getElementById('list_product').disabled = document.getElementById('all_product').checked;
    }
    /*
     $('.products').select2();
     $(document).ready(function(){
        let row_number = 1;
        $("#add_row").click(function(e){
        $('.products').select2('destroy');
 
        e.preventDefault();
        let new_row_number = row_number - 1;
        $('#product' + row_number).html($('#product' + new_row_number).html()).find('td:first-child');
        $('#products_table').append('<tr id="product' + (row_number + 1) + '">\
            <select name="products[]" id="sl0" class="products" style="width: 100%;">\
                                    @foreach ($products as $product)\
                                        <option value="{{ $product->id }}">\
                                            {{ $product->Product_name }}\
                                        </option> @endforeach </select>\
        </tr>');
        //$('#sl'+row_number ).select2({});
        row_number++;
        //$('.products').select2();
        });

        $("#delete_row").click(function(e){
        e.preventDefault();
        if(row_number > 1){
            $("#product" + (row_number - 1)).html('');
            row_number--;
        }
        });
    });
   */
</script>

@endsection