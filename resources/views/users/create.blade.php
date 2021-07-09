@extends('layouts.master')
@section('title') Create User @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
    @endif
    @if(session('error'))
		<div class="alert alert-success">
			{{session('error')}}
		</div>
    @endif
    <!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('users.store', $client_slug)}}">
    	@csrf
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="name" autocomplete="off" required>
                <label class="form-label">Name</label>
            </div>
        </div>
        <!--                        
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="username" autocomplete="off" required>
                <label class="form-label">UserName</label>
            </div>
        </div>
        -->               
		<h2 class="card-inside-title">Roles</h2>
        <div class="form-group">
            <input class="form-control {{$errors->first('roles') ? "is-invalid" : "" }}" type="radio" name="roles[]" id="ADMIN" value="SUPERADMIN" required> <label for="ADMIN">Super Admin</label>
            <input class="form-control {{$errors->first('roles') ? "is-invalid" : "" }}" type="radio" name="roles[]" id="STAFF" value="ADMIN"> <label for="STAFF">Admin</label>
            <div class="invalid-feedback">
                {{$errors->first('roles')}}
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="phone" minlength="10" maxlength="12" autocomplete="off" required>
                <label class="form-label">Phone Number</label>
            </div>
            <div class="help-info">Min.10, Max. 12 Characters</div>
        </div>

        <div class="form-group">
            <div class="form-line">
                <textarea name="address" rows="4" class="form-control no-resize" placeholder="Address" autocomplete="off" required></textarea>
            </div>
        </div>

        <h2 class="card-inside-title">Avatar Image</h2>
        <div class="form-group">
         <div class="form-line">
             <input type="file" name="avatar" class="form-control" id="avatar" autocomplete="off">
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="email" class="form-control" name="email" autocomplete="off" required>
                <label class="form-label">Email</label>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="password" class="form-control {{$errors->first('password') ? "is-invalid" : ""}}" name="password" id="password" required>
                <label for="password" class="form-label">Password</label>
                <div class="invalid-feedback">
                    {{$errors->first('password')}}
                </div>
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="password" class="form-control {{$errors->first('password_confirmation') ? "is-invalid" : ""}}" name="password_confirmation" id="password_confirmation" required>
                <label for="password_confirmation" class="form-label">Password Confirmation</label>
                <div class="invalid-feedback">
                    {{$errors->first('password_confirmation')}}
                </div>
            </div>
        </div>
                        
        <button id="btnSubmit" class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
    </form>
    <!-- #END#  -->		

@endsection
@section('footer-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
    $(function () {
        $("#btnSubmit").click(function () {
            var password = $("#password").val();
            var confirmPassword = $("#password_confirmation").val();
            if (password != confirmPassword) {
                Swal.fire('Passwords Do not Match');
                return false;
            }
            return true;
        });
    });
</script>
@endsection