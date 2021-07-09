@extends('auth.passwords.template')

@section('content')

<div class="container" style="margin-top: 70px;">
    <div class="row align-middle">
        <div class="col-sm-12 col-md-12">
            <nav aria-label="breadcrumb" class="">
                <ol class="breadcrumb px-0 button_breadcrumb">
                    <li class="breadcrumb-item" style="color: #6a3137 !important;margin-top:30px; font-size:20px;"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="margin-top:30px;">Reset Password</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="col-md-12 login-label">
        <h1>Reset</h1>
        <p> Your Password</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mx-auto contact_card" style="border-radius:15px;">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <!--<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>-->

                        
                            <input id="email" type="email" placeholder="Email" class="form-control contact_input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                </div>
            </div>    
                        <div class="col-md-12 mx-auto text-center">
                            <button type="submit" class="btn btn_login_form reset" >{{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                              
                           
                    </form>
                
            
        </div>
    </div>
</div>
@endsection
