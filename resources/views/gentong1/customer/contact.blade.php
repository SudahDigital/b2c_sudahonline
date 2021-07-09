@extends($client_slug.'.customer.layouts.template-nobanner')
@section('content')
    <div class="container" style="margin-top:80px;">
        <div class="row align-middle">
            <div class="col-sm-12 col-md-12">
                <nav aria-label="breadcrumb" class="">
                    <ol class="breadcrumb px-0 button_breadcrumb kontak">
                        <li class="breadcrumb-item" style="color: #6a3137 !important;margin-top:30px; font-size:20px;"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="margin-top:30px;">Kontak Kami</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row section_content">
            <div class="col-sm-12 mb-5">
                <div class="row section_content" style="margin-top: 3.8rem;">
                    <div class="col-sm-12 col-md-6">
                        <div class="card mx-auto item_product contact_kami">
                            <div class="row card-body">

                                <div class="col col-md-3">
                                    <i class="fa fa-phone" id="i-kontak"></i>
                                </div>
                                <div class="col col-md-9">
                                    <p class="card-title telp">Telepon</p>
                                    <h5 class="card-title no_telp">‭+{{ $number_contact }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="card mx-auto item_product contact_kami">
                            <div class="row card-body">

                                <div class="col col-md-3">
                                    <i class="fa fa-envelope" id="i-envelop"></i>
                                </div>
                                <div class="col col-md-9">
                                    <p class="card-title" id="env">Email</p>
                                    <h5 class="card-title" id="e_env"> {{$email_contact}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br>
    </div>
@endsection
