@extends('layouts.master')
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
            <div class="form-group">
                <label class="form-label">Upload Barcode</label>
                <!-- <div class="form-line">
                     <input type="file" name="barcode" class="form-control" id="barcode" autocomplete="off">
                </div> -->
                <div class="form-line">
                    @if($barcode_image)
                    <img src="{{asset('assets/image/'.$client_slug.'/'.$barcode_image)}}" width="120px"/>
                    @else
                    No Image
                    @endif
                    <input type="file" name="barcode" class="form-control" id="barcode" autocomplete="off">
                </div>
            </div>
            <div class="form-group form-float">
                <label class="form-label">Contact Number</label>
                <div class="form-line">
                    <div class="input-group">
                        <span class="input-group-addon">+62</span>
                        <input id="phone_whatsapp" type="text" class="form-control" name="contact_no"  
                        value="{{$contact_1}}" autocomplete="off" required>
                    </div>
                    
                </div>
                <div class="help-info">Min.10, Max. 13 Characters</div>
            </div>

            <div class="form-group form-float">
                <label class="form-label">Whatsapp Number</label>
                <div class="form-line">
                    <div class="input-group">
                        <span class="input-group-addon">+62</span>
                        <input type="text" class="form-control" value="{{$contact_2}}" name="wa_no" autocomplete="off" required>
                    </div>
                </div>
                <div class="help-info">Min.10, Max. 13 Characters</div>
            </div>     
             <div class="form-group form-float">
                <label class="form-label">Email</label>
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$client_email}}" name="client_email" autocomplete="off" required>
                </div>
            </div>       
        <button class="btn btn-primary waves-effect" type="submit">EDIT</button>&nbsp;
        <a href="{{route('contacts.index', $client_slug)}}" class="btn bg-deep-orange waves-effect" >&nbsp;CLOSE&nbsp;</a>
    </form>

    <!-- #END#  -->		

@endsection