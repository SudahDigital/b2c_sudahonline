@extends($client_slug.'.layouts.master')
@section('title') Edit Contact @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('contacts.update',[$contact_id, $client_slug])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="col-12">
            <div class="col-12 row">
                <div class="col-sm-2">
                  <div class="form-group form-float">
                        <div class="form-line col-6">
                            <input type="text" class="form-control" value="+62" name="kode_negara1" autocomplete="off" disabled>
                            <label class="form-label">Code Negara</label>
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" value="+62" name="kode_negara2" autocomplete="off" disabled>
                            <label class="form-label">Code Negara</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10">
                   <div class="form-group form-float">
                        <div class="form-line">
                            <div class="input-group">
                                <span class="input-group-addon">+62</span>
                                <input id="phone_whatsapp" type="text" class="form-control" placeholder="Whatsapp  (Ex: 81211111111)" 
                                name="phone_whatsapp" onkeypress="return isNumberKey(event)" 
                                value="{{old('phone_whatsapp')}}" autocomplete="off" required>
                            </div>
                            
                        </div>
                        <div class="help-info">Min.10, Max. 13 Characters</div>
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$contact_2}}" name="wa_no" autocomplete="off" required>
                            <label class="form-label">Whatsapp Number</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary waves-effect" type="submit">EDIT</button>&nbsp;
        <a href="{{route('contacts.index', $client_slug)}}" class="btn bg-deep-orange waves-effect" >&nbsp;CLOSE&nbsp;</a>
    </form>

    <!-- #END#  -->		

@endsection