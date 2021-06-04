@extends('auth.template-auth')
@section('title') Reset Password @endsection
@section('content')

<div class="container" >
    <div class="d-flex justify-content-center mx-auto">
        <div class="col-md-2">
           <img src="{{ asset('assets/image/LOGO MEGACOOLS_DEFAULT.png') }}" class="img-thumbnail" style="background-color:transparent; border:none;" alt="LOGO MEGACOOLS_DEFAULT">  
        </div>
        
    </div>
    
    <div class="col-md-12 login-label">
        <h1>Reset</h1>
        <p> Password</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card mx-auto contact_card" 
                style="border-top-left-radius:25px;
                border-top-right-radius:25px;
                border-bottom-right-radius:0;
                border-bottom-left-radius:0;">

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
                            <button type="submit" class="btn btn_login_form reset" >{{ __('Kirim') }}
                            </button>
                        </div>
                              
                           
                    </form>
                
            
        </div>
    </div>
</div>
@endsection
