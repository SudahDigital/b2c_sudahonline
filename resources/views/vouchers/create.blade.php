@extends('layouts.master')
@section('title') Create Voucher @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST"  action="{{route('vouchers.store')}}">
    	@csrf
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="name" autocomplete="off" required>
                <label class="form-label">Voucher Name</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line" id="code_">
                <input type="text" class="form-control" id="code"  name="code" autocomplete="off" required>
                <label class="form-label">Voucher Code</label>
            </div>
            <label id="name-error" class=""></label>
            <small class=""></small>
        </div>

        <div class="form-group">
            <div class="form-line">
                <textarea name="description" rows="4" class="form-control no-resize" placeholder="Description" autocomplete="off" required></textarea>
            </div>
        </div>
        
        <h2 class="card-inside-title">Voucher Type</h2>
        <div class="form-group">
            <input class="form-control {{$errors->first('type') ? "is-invalid" : "" }}" type="radio" name="type" id="percentage" value="1"> <label for="percentage">Percentage</label>
            <input class="form-control {{$errors->first('type') ? "is-invalid" : "" }}" type="radio" name="type" id="flat" value="2"> <label for="flat">Flat</label>
            <div class="invalid-feedback">
                {{$errors->first('type')}}
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" name="discount_amount" autocomplete="off" min="0"  required/>
                <label class="form-label">Amount</label>
            </div>
        </div>

        <h2 class="card-inside-title">Expires</h2>
        <div class="form-group">
            <div class="form-line" id="bs_datepicker_container">
                <input type="text" id="datepicker" name="expires_at" class="form-control" placeholder="Please choose a date...">
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" id="max_uses" name="max_uses" autocomplete="off" required>
                <label class="form-label">Maximum Number Of Usages</label>
            </div>
        </div>
        
        <button id="save" class="btn btn-primary waves-effect" name="save_action" value="SAVE" type="submit">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
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
                url: '{{URL::to('/ajax/vouchers/search')}}',
                type: 'get',
                data: {
                    'code' : code,
                },
                success: function(response){
                    if (response == 'taken' && code !="" ) {
                    $('#code_').addClass("focused error");
                    $('#code_').siblings("label").addClass("error").text('Sorry... Code Already Exists');
                    $('#code_').siblings("small").text('');
                    $('#save').prop('disabled', true);
                    }else if (response == 'not_taken' && code !="") {
                    $('#code_').addClass("");
                    $('#code_').siblings("small").addClass("text-primary").text('Code Available');
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
</script>

@endsection