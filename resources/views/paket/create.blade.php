@extends('layouts.master')
@section('title') Create Paket @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('paket.store')}}">
    	@csrf
        <div class="form-group form-float">
            <div class="form-line" id="code_">
                <input type="text" class="form-control" id="code" name="paket_name" autocomplete="off" required>
                <label class="form-label">Paket Name</label>
            </div>
            <label id="name-error" class=""></label>
            <small class=""></small>
        </div>
        <!--
        <h2 class="card-inside-title">Groups</h2>
        <select name="groups"  id="groups" class="form-control" required></select>
        <br>
        <br>
        -->
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="display_name" autocomplete="off" required>
                <label class="form-label">Display Name</label>
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="bonus_quantity" autocomplete="off" required>
                <label class="form-label">Bonus Quantity</label>
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="purchase_quantity" autocomplete="off" required>
                <label class="form-label">Purchase Quantity</label>
            </div>
        </div>
        

        <button class="btn btn-primary waves-effect" name="save_action" value="SAVE" type="submit">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<!--
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
-->
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
                url: '{{URL::to('/ajax/paket/search')}}',
                type: 'get',
                data: {
                    'code' : code,
                },
                success: function(response){
                    if (response == 'taken' && code !="" ) {
                    $('#code_').addClass("focused error");
                    $('#code_').siblings("label").addClass("error").text('Sorry... Paket Name Already Exists');
                    $('#code_').siblings("small").text('');
                    $('#save').prop('disabled', true);
                    }else if (response == 'not_taken' && code !="") {
                    $('#code_').addClass("");
                    $('#code_').siblings("small").addClass("text-primary").text('Paket Name Available');
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
    /*$('#groups').select2({
      placeholder: 'Select an item',
      ajax: {
        url: '{{URL::to('/ajax/groups/search')}}',
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                        id: item.id,
                        text: item.display_name
                      
                  }
              })
          };
        }
        
      }
    });
    */
    </script>

@endsection