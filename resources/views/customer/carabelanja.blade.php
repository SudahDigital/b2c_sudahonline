@extends('customer.layouts.template-nobanner')
@section('content')
    <div class="container" style="margin-top: 80px;">
        <div class="row align-middle">
            <div class="col-sm-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-0 button_breadcrumb cr_bl">
                        <li class="breadcrumb-item" style="color: #6a3137 !important;margin-top:30px;"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="margin-top:30px;">Cara Berbelanja</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>    
    <div class="card mx-auto cara_belanja">
        <div id="cara-belanja">
            <div class="row card-body">
            
                <div class="col-6  col-md-2 card-img-top">
                    <img src="{{asset('assets/image/'.$client_slug.'/cari-produk.png')}}" class="card-img-top"  alt="...">
                </div>
                <div class="col-6  col-md-4 card-img-top">
                    <h5 class="card-title">1. Cari Produk</h5>
                    <p>Terdapat banyak pilihan produk, dan dapat dilihat dan dicari di halaman utama dan category.</p>
                </div>

                <div class="col-6 col-md-2 card-img-top">
                    <img src="{{asset('assets/image/'.$client_slug.'/keranjang.png')}}" class="card-img-top"  alt="...">
                </div>
                <div class="col-6 col-md-4 card-img-top">
                    <h5 class="card-title">2. Masukkan Dalam Keranjang Belanja</h5>
                    <p>Bila sudah menemukannya, masukkan pilihan produk yang kamu
                        butuhkan dengan menekan tombol (+) pada bagian bawah.</p>
                </div>

                <div class="col-6 col-md-2 card-img-top">
                    <img src="{{asset('assets/image/'.$client_slug.'/isi-data.png')}}" class="card-img-top"  alt="...">
                </div>
                <div class="col-6 col-md-4 card-img-top">
                    <h5 class="card-title">3. Isi Data</h5>
                    <p>Proses bisa kamu lanjutkan dengan mengisi data diri. Lalu kamu konfirmasikan daftar ini di halaman Konfirmasi Pemesanan sebelum kamu
                        mengirimkan kepada admin Ice Gentong.</p>
                </div>

                <div class="col-6 col-md-2 card-img-top">
                    <img src="{{asset('assets/image/'.$client_slug.'/confirm-wa.png')}}" class="card-img-top"  alt="..." >
                </div>
                <div class="col-6 col-md-4 card-img-top">
                    <h5 class="card-title">4. Konfirmasi Via  Whatsapp</h5>
                    <p>Bila sudah dipastikan, tinggal tekan tombol Kirim.
                        Order yang kamu masukkan akan secara otomatis kami buatkan dan kamu tinggal
                        menyampaikannya kepada admin WhatsApp kami.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
