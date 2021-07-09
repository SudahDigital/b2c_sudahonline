@extends('customer.layouts.template-nobanner')
@section('content')
    <div class="container" style="margin-top: 70px;">
        <div class="row align-middle">
            <div class="col-sm-12 col-md-12">
                <nav aria-label="breadcrumb" class="">
                    <ol class="breadcrumb px-0 button_breadcrumb">
                        <li class="breadcrumb-item" style="color: #6a3137 !important;margin-top:30px; font-size:20px;"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="margin-top:30px;">Sign Up</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="card mx-auto contact_card" style="border-radius:15px;">
                        <div class="card-body">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control contact_input @error('name') is-invalid @enderror" placeholder="Nama" id="name" required autocomplete="off" autofocus value="{{ old('name') }}">
                                <!--<label for="name" class="contact_label">{{ __('Nama') }}</label>-->
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <hr style="border:1px solid rgba(116, 116, 116, 0.507);">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control contact_input @error('email') is-invalid @enderror" placeholder="Email" id="email" required autocomplete="off" value="{{ old('email') }}">
                                <!--<label for="email" class="contact_label">{{ __('Email') }}</label>-->
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <hr style="border:1px solid rgba(116, 116, 116, 0.507);">
                            <div class="form-group">
                                <input type="password" name="password" class="form-control contact_input @error('password') is-invalid @enderror" placeholder="Kata Sandi" id="password" required autocomplete="off" value="{{ old('password') }}">
                                <!--<label for="password" class="contact_label">{{ __('Kata Sandi') }}</label>-->
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <hr style="border:1px solid rgba(116, 116, 116, 0.507);">
                            <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control contact_input" placeholder="Konfirmasi Kata Sandi" id="password-confirm" required autocomplete="off">
                                <!--<label for="password-confirm" class="contact_label">{{ __('Konfirmasi Kata Sandi') }}</label>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mx-auto text-center">
                        <button type="submit" class="btn btn_login_form">{{ __('Sign Up') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <br>
        <br>
    </div>
@endsection
