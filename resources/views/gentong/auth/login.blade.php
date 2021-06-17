@extends($client_slug.'.customer.layouts.template-nobanner')
@section('content')
    <div class="container" style="margin-top: 70px;">
        <div class="row align-middle">
            <div class="col-sm-12 col-md-12">
                <nav aria-label="breadcrumb" class="">
                    <ol class="breadcrumb px-0 button_breadcrumb">
                        <li class="breadcrumb-item" style="color: #6a3137 !important;margin-top:30px; font-size:20px;"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="margin-top:30px;">Sign In</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="col-md-12 login-label">
            <h1>Sign In</h1>
            <p> Your Account</p>
        </div>
            
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <form method="POST" action="{{ route('login', [$client_slug]) }}">
                    @csrf
                    <div class="card mx-auto contact_card" style="border-radius:15px;">
                        <div class="card-body">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control contact_input @error('email') is-invalid @enderror" placeholder="Email" id="email" required autocomplete="off" autofocus value="{{ old('email') }}">
                                <!--<label for="email" class="contact_label">{{ __('Email') }}</label>-->
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <hr style="border:1px solid rgba(116, 116, 116, 0.507);">
                            <div class="form-group">
                                <input type="password" name="password" class="form-control contact_input @error('password') is-invalid @enderror" placeholder="Kata Sandi" id="password" required autocomplete="off" value="{{ old('password') }}">
                                <!--<label for="password" class="contact_label_pass">{{ __('Kata Sandi') }}</label>-->
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback mx-auto" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-md-12 login-label" style="margin-top:20px;">
                        @if (Route::has('password.request'))
                            <a  href="{{ route('password.request') }}">
                              <p>{{ __('Forgot Your Password?') }}</p>
                            </a>
                        @endif
                    </div>
                    <!--
                    <div class="col-md-12 login-label text-center" style="margin-top:20px;">
                         <p>Don't have an account..? <a style="color:#6a3137; font-size:20px; font-weight:900;" href="{{ route('register', $client_slug) }}">Sign Up</a></p>
                    </div>
                    -->
                    <div class="col-md-12 mx-auto text-center">
                        <!--<button type="submit" class="btn btn_login_form" >{{ __('Sign In') }}
                        </button>-->
                        <button type="submit" class="btn btn_login_form" >Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <br>
@endsection
