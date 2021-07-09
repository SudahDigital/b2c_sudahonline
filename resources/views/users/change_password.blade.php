@extends('layouts.master')
@section('title') Change Password @endsection
@section('content')

@if(session('error'))
<div class="alert alert-danger">
    {{session('error')}}
</div>
@endif
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
    @endif
    <!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('post.changepass')}}">
        @csrf
        <div class="form-group form-float">
            <div class="form-line">
                <input type="password" class="form-control {{$errors->first('password') ? "is-invalid" : ""}}" name="current-password" id="current-password" required>
                <label for="current-password" class="form-label">Current Password</label>
                <div class="invalid-feedback">
                    {{$errors->first('password')}}
                </div>
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
                        
        <button id="btnSubmit" class="btn btn-primary waves-effect" type="submit">CHANGE PASSWORD</button>
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
                Swal.fire('Confirm Passwords Do not Match');
                return false;
            }
            return true;
        });
    });
</script>
@endsection