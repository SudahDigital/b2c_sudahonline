@extends('layouts.master')
@section('title') Edit User @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('users.update',[$user->id, $client_slug])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" value="{{$user->name}}" name="name" autocomplete="off" required>
                <label class="form-label">Name</label>
            </div>
        </div>
        
        <!--
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" value="{{$user->username}}" name="username" autocomplete="off" required disabled>
                <label class="form-label">UserName</label>
            </div>
        </div>
        -->
        <h2 class="card-inside-title">Status</h2>
        <div class="form-group">
            <input type="radio" value="ACTIVE" name="status" id="ACTIVE" {{$user->status == 'ACTIVE' ? 'checked' : ''}}>
            <label for="ACTIVE">ACTIVE</label>
                            &nbsp;
            <input type="radio" value="INACTIVE" name="status" id="INACTIVE" {{$user->status == 'INACTIVE' ? 'checked' : ''}}>
            <label for="INACTIVE">INACTIVE</label>
        </div>

        <h2 class="card-inside-title">Roles</h2>
        <div class="form-group">
            <input 
            type="radio"
            {{in_array("SUPERADMIN", json_decode($user->roles)) ? "checked" : ""}} 
            name="roles[]" 
            class="form-control {{$errors->first('roles') ? "is-invalid" : "" }}"
            id="ADMIN" 
            value="SUPERADMIN"> 
            <label for="ADMIN">Super Admin</label>

            <input 
            type="radio"
            {{in_array("ADMIN", json_decode($user->roles)) ? "checked" : ""}} 
            name="roles[]" 
            class="form-control {{$errors->first('roles') ? "is-invalid" : "" }}"
            id="STAFF" 
            value="ADMIN"> 
            <label for="STAFF">Admin</label>

            <div class="invalid-feedback">
                {{$errors->first('roles')}}
            </div>
            
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" value="{{$user->phone}}" name="phone" minlength="10" maxlength="12" autocomplete="off" required>
                <label class="form-label">Phone Number</label>
            </div>
            <div class="help-info">Min.10, Max. 12 Characters</div>
        </div>

        <div class="form-group">
            <div class="form-line">
                <textarea name="address" rows="4" class="form-control no-resize" placeholder="Address" autocomplete="off" required>{{$user->address}}</textarea>
            </div>
        </div>

        <h2 class="card-inside-title">Avatar Image</h2>
        <div class="form-group">
         <div class="form-line">
            @if($user->avatar)
            <img src="{{asset('storage/'.$user->avatar)}}" width="120px"/>
            @else
            No Avatar
            @endif
            <input type="file" name="avatar" class="form-control" id="avatar" autocomplete="off">
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="email" value="{{$user->email}}" class="form-control" name="email" autocomplete="off" disabled="disabled" required>
                <label class="form-label">Email</label>
            </div>
        </div>

        <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>&nbsp;
        <a href="{{route('users.index', $client_slug)}}" class="btn bg-deep-orange waves-effect" >&nbsp;CLOSE&nbsp;</a>
    </form>

    <!-- #END#  -->		

@endsection