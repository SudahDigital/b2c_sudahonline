@extends('customer.layouts.template-nocart')
@section('title') Profil @endsection
@section('content')
<style>
    @media only screen and (max-width: 411px) {
        .card-body{
            padding: 15px 4px;
        }
        
    }
</style>
    <div class="container" style="">
        <div class="row align-middle">
            <div class="col-sm-12 col-md-12">
                <nav aria-label="breadcrumb" class="float-right mt-0">
                    <ol class="breadcrumb px-0 button_breadcrumb">
                        <li id="prf-brd" class="breadcrumb-profil-item active mt-1" aria-current="page">Kontak Kami</li>&nbsp;
                        <li class="breadcrumb-profil-item" style="color: #000!important;"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mb-5 contact-row" style="z-index:2">
                <div class="row section_content" style="margin-top: 3.8rem;">
                    <div class="col-lg-6 mb-4">
                        <div class="row">
                            <div class="col-3 col-md-4">
                                <div class="card contact-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-phone-alt" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9 col-md-8">
                                <p class="contact-tele-name mb-0 mt-2">Telepon</p>
                                <h5 class="contact-tele-number">‭021-777-000‬</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-3 col-md-4">
                                <div class="card contact-card">
                                    <div class="card-body text-center">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9 col-md-8">
                                <p class="contact-email-name mb-0 mt-2">Email</p>
                                <h5 class="contact-email">megacool@gmail.com</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        if ($(window).width() <= 600) {
            //$('#prf-brd').removeClass('mt-1');
            //$('#prf-brd').addClass('mt-2');
        } 
        if ($(window).width() <= 411) {
            $('.col-9').addClass('ml-n3');
            //$('.contact-row').addClass('mt-5');
        } 
    </script>
@endsection
