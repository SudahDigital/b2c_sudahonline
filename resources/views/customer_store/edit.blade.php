@extends('layouts.master')
@section('title') Edit Customer @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('customers.update',[$cust->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group form-float">
            <div class="form-line" id="code_">
                <input type="text" class="form-control" name="store_code" autocomplete="off" 
                value="{{$cust->store_code}}" readonly required>
                <label class="form-label">Customer Code / Search Key</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="store_name" value="{{$cust->store_name}}" autocomplete="off" required>
                <label class="form-label">Name</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="email" class="form-control" value="{{$cust->email}}" name="email" autocomplete="off" required>
                <label class="form-label">Email</label>
            </div>
        </div>
        <h2 class="card-inside-title" >City</h2>
            <select name="city_id"  id="city_id" class="form-control" required></select>
        <br>
        <br>
        <div class="form-group">
            <div class="form-line">
                <textarea name="address" rows="4" class="form-control no-resize" placeholder="Address" autocomplete="off" required>{{$cust->address}}</textarea>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input id="txtNumber" value="{{$cust->phone}}" class="form-control" onkeypress="return isNumberKey(event)"  type="text" name="phone" minlength="10" maxlength="13" autocomplete="off">
                <label class="form-label">Whatsapp Number</label>
            </div>
            <div class="help-info">Min.10, Max. 13 Characters</div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{$cust->phone_owner}}" id="txtNumber" class="form-control" onkeypress="return isNumberKey(event)" name="phone_owner"  autocomplete="off" >
                <label class="form-label">Owner Phone</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{$cust->phone_store}}" id="txtNumber" class="form-control" onkeypress="return isNumberKey(event)" name="phone_store"  autocomplete="off" >
                <label class="form-label">Office/Shop Phone</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="name" value="{{$cust->name}}" autocomplete="off" required>
                <label class="form-label">Contact Person</label>
            </div>
        </div>

        <h2 class="card-inside-title">Payment Term</h2>
            <select name="payment_term"  id="payment_term" class="form-control" required>
                <option value="7 Days" {{$cust->payment_term == '7 Days' ? 'selected' : '' }}>7 Days</option>
                <option value="45 Days" {{$cust->payment_term == '45 Days' ? 'selected' : '' }}>45 Days</option>
                <option value="60 Days" {{$cust->payment_term == '60 Days' ? 'selected' : '' }}>60 Days</option>
            </select>
        <br>
        <!--
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="payment_term" value="{{$cust->payment_term}}" autocomplete="off" required>
                <label class="form-label">Payment Term</label>
            </div>
        </div>
        -->
        <h2 class="card-inside-title">Sales Representative</h2>
            <select name="user_id"  id="user" class="form-control" required></select>
        <br>
        
        <button class="btn btn-primary waves-effect" name="save_action" value="SAVE" type="submit" style="margin-top: 20px;">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection

@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
            return false;
            return true;
        }
    $('#payment_term').select2(); 

    $('#user').select2({
      placeholder: 'Select an item',
      ajax: {
        url: '{{URL::to('/ajax/users/search')}}',
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

    var users = JSON.stringify([{!! $cust->users !!}]);
    users = JSON.parse(users);
    users.forEach(function(cust){
    var option = new Option(cust.name, cust.id, true, true);
    $('#user').append(option).trigger('change');
    });

    //city
    $('#city_id').select2({
        placeholder: 'Select a City',
        ajax: {
            url: '{{URL::to('/customer/ajax/city_search')}}',
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                            id: item.id,
                            text: item.city_name,
                            
                    }
                })
            };
            }
            
        }
    });

    var cities = JSON.stringify([{!! $cust->cities !!}]);
    cities = JSON.parse(cities);
    cities.forEach(function(cust_city){
    var option_city = new Option(cust_city.city_name, cust_city.id, true, true);
    $('#city_id').append(option_city).trigger('change');
    });
</script>

@endsection