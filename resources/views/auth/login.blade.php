@extends('auth.template-auth')
@section('title') Login @endsection
@section('content')
<style>
    @media only screen and (max-width: 600px) {
        .col-md-2{
            width: 40%;
        }
        
    }
    @media only screen and (max-width: 540px) {
        .col-md-7{
            width: 90%;
        }
        
    }
</style>
    <div class="container pt-5">
        <div class="d-flex justify-content-center mx-auto" >
            <div class="col-md-3 image-logo-login" style="z-index: 2;">
               <img src="{{ asset('assets/image/Logo_SudahOnline.png') }}" class="img-thumbnail" style="background-color:transparent; border:none;" alt="Logo_SudahOnline">  
            </div>
            
        </div>
        <div class="col-md-12 login-label mt-4" style="z-index:2;">
            <h1 style="color:#174C7C;">Masuk</h1>
            <p style="color:#174C7C;"> Gunakan Akun Anda</p>
        </div>
            
        <div class="row justify-content-center">
            <div class="col-md-7" style="z-index: 2">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="card mx-auto contact_card" 
                        style=" border-top-left-radius:25px;
                                border-top-right-radius:25px;
                                border-bottom-right-radius:0;
                                border-bottom-left-radius:0;
                                border:2px solid rgba(116, 116, 116, 0.507);">
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
                              <p style="color:#174C7C;">{{ __('Lupa Password?') }}</p>
                            </a>
                        @endif
                    </div>
                    <!--
                    <div class="col-md-12 login-label text-center" style="margin-top:20px;">
                         <p>Don't have an account..? <a style="color:#6a3137; font-size:20px; font-weight:900;" href="{{ route('register') }}">Sign Up</a></p>
                    </div>
                    -->
                    <div class="col-md-12 mx-auto text-center">
                        <button type="submit" class="btn btn_login_form" >{{ __('Masuk') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
    if($(window).width() < 600){
        $('.login-label').removeClass('mt-4').addClass('mt-3');
        $('.image-logo-login').addClass('px-5');
        $('.container').removeClass('pt-5').addClass('pt-4');
        //$('img-thumbnail').addClass('mx-5');
    }
</script>
@endsection
