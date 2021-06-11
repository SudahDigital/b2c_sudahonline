<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>MT-Gentong versi 1</title>

    <link rel="icon" href="{{ asset('assets/image/'.$client_slug.'/logo-gentong-nav.png')}}" type="image/png" sizes="16x16">
    <!-- Bootstrap CSS CDN -->
    <link href="//db.onlinewebfonts.com/c/3dd6e9888191722420f62dd54664bc94?family=Myriad+Pro" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-183852861-1"></script>
    <style type="text/css">
        /*Hidden class for adding and removing*/
        .lds-dual-ring.hidden {
            display: none;
        }

        /*Add an overlay to the entire page blocking any further presses to buttons or other elements.*/
        .overlay_ajax {
            position: fixed;
            left: 39%;
            top: 40%;
            width: 100%;
            height: 100%;
            background: transparent;
            z-index: 9999;
            transition: all 0.5s;
        }

        @media(min-width:1366px){
            .overlay_ajax {
            left: 47%;
            }
            .preloader .loading {
            left: 40%;
            top: 40%;
            }  
        }

        .preloader{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: #fff;
        }

        .preloader .loading {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%,-50%);
            font: 14px arial;
        }
         .ribbon {
        position: absolute;
        left: -5px; top: -5px;
        z-index: 1;
        overflow: hidden;
        width: 200px; height: 200px;
        text-align: right;
        }

        .span-ribbon {
        font-size: 20px;
        font-weight: bold;
        color: #FFF;
        text-transform: uppercase;
        text-align: center;
        line-height: 40px;
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
        width: 225px;
        display: block;
        background: #79A70A;
        background: linear-gradient(#F79E05 0%, #8F5408 100%);
        box-shadow: 0 6px 10px -5px rgba(0, 0, 0, 1);
        position: absolute;
        top: 40px; left: -52px;
        }

        .span-ribbon::before {
        content: "";
        position: absolute; left: 0px; top: 100%;
        z-index: -1;
        border-left: 7px solid #8F5408;
        border-right: 7px solid transparent;
        border-bottom: 7px solid transparent;
        border-top: 7px solid #8F5408;
        
        }
        
        .span-ribbon::after {
        content: "";
        position: absolute; right: 0px; top: 100%;
        z-index: -1;
        border-left: 7px solid transparent;
        border-right: 7px solid #8F5408;
        border-bottom: 7px solid transparent;
        border-top: 7px solid #8F5408;
        
        }

        
    </style>
    <script>
        $(document).ready(function(){
          $(".preloader").fadeOut();
        })
    </script>
</head>
<body>
    <div class="preloader" id="preloader">
        <div class="loading">
          <img src="{{ asset('assets/image/'.$client_slug.'/preloader.gif') }}" width="80" alt="preloader">
          <p style="font-weight:900;line-height:2;color:#6a3137;margin-left: -10%;">Harap Tunggu</p>
        </div>
    </div>

    <div id="loader" class="lds-dual-ring hidden overlay_ajax"><img class="hidden" src="{{ asset('assets/image/'.$client_slug.'/preloader.gif') }}" width="80" alt="preloader"></div>
    
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
      </div>
    @endif

    <div class="wrapper">
         <!-- Sidebar  -->
         <nav id="sidebar">
           
            <div class="sidebar-header mx-auto">
                <a href="{{url('/', $client_slug) }}">
                    <img src="{{ asset('assets/image/'.$client_slug.'/logo-gentong.png') }}" width="70%" height="auto" class="d-inline-block align-top" alt="logo-gentong" loading="lazy">
                </a>
            </div>
            <ul class="list-unstyled components">
                
                <li class="">
                    <a href="{{ url('/', $client_slug) }}">Beranda</a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Produk</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                            @foreach($categories as $key => $value)
                                <li>
                                    <a href="{{route('category.index', ['id'=>$value->id, $client_slug] )}}" style="font-size: 1.1em !important;">{{$value->name}}</a>
                                </li>
                            @endforeach
                    </ul>
                </li>
                <li>
                    <a href="{{URL::route('cara_belanja', $client_slug)}}">Cara Berbelanja</a>
                </li>
                <li>
                    <a href="{{URL::route('contact', $client_slug)}}">Kontak Kami</a>
                </li>
                <!--
                <li>
                    <a href="{{URL::route('riwayat_pemesanan', $client_slug)}}">Riwayat Pesanan</a>
                </li>
                -->
            </ul>

             @if(\Auth::user())
                <div class="mx-auto text-center">
                    <form action="{{route('logout')}}" method="POST">
                        @csrf   
                        <div id="log">   
                            <button class="btn logout">
                                    Sign Out
                            </button>
                        </div>
                    </form>
                </div>
            @else    
                    <!--    
                    <div class="mx-auto text-center">
                        <a href="{{route('login', $client_slug)}}" class="btn login">Sign In</a>
                    </div>
                            
                    <div class="mx-auto text-center">  
                            <a href="{{route('register', $client_slug)}}" class="register">Sign Up</a>
                    </div> 
                    -->
            @endif
            
            
            <div class="mx-auto text-center" style="margin-top: 35px;">
                <div class="social-icons">
                    <a href="https://www.facebook.com/Gentongicecream/"  target="_blank"><i class="fab fa-facebook" ></i></a>
                    <a href="https://instagram.com/gentongicecream?igshid=10b120fidnx58"  target="_blank"><i class="fab fa-instagram "></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="https://twitter.com/kedaigentong?s=08" target="_blank"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

         </nav>

        <div id="content">

            
            <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="z-index: 1.5;">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn button-burger-menu">
                        <i class="fas fa-bars fa-2x" style="color:#693234;"></i>
                    </button>
                   
                    <a class="navbar-brand nav-center" href="{{ url('/') }}">
                    
                        <img src="{{ asset('assets/image/'.$client_slug.'/logo-gentong.png') }}" class="p-0 m-0 d-inline-block align-top" alt="logo-gentong" loading="lazy">
                    </a>
                    <form action="{{route('search.index', $client_slug)}}" class="form-inline my-2 my-lg-0 ml-auto d-none d-md-inline-block">
                        <div class="input-group">
                            <div class="input-group-append">
                                <button class="btn  my-2 my-sm-0 search_botton_navbar" type="submit" id="button-search-addon" style="border-radius: 50%;"><i class="fa fa-search"></i></button>&nbsp;&nbsp;&nbsp;
                            </div>
                            <input class="form-control d-inline-block m-100 search_input_navbar" name="keyword" type="text" value="{{Request::get('keyword')}}" placeholder="Search" aria-label="Search" aria-describedby="button-search-addon">
                              
                        </div>
                    </form>
                    <a href="#searh_responsive" class="btn btn-info d-md-none" data-toggle="modal" data-target="#searchModal" style="border-radius: 50%; background:#693234;; border:none;"><i class="fa fa-search" style=""></i></a>
                </div>
                
            </nav>

            <!-- Page Content  -->
            @yield('content')

           

        </div>
    </div>

    <div class="overlay"></div>

    <!-- Modal -->
    <div class="modal fade" id="searchModal" role="dialog">
        <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content" style="background: #FDD8AF">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <form action="{{route('search.index', $client_slug)}}">
                            <div class="input-group">
                                <div class="input-group-append">
                                        <button class="btn search_botton_navbar" type="submit" id="button-search-addon" style="border-radius: 50%;"><i class="fa fa-search"></i></button>
                                        <input class="form-control d-block search_input_navbar" name="keyword" type="text" value="{{Request::get('keyword')}}" placeholder="Search" aria-label="Search" aria-describedby="button-search-addon">
                                </div>
                                    
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('assets/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>-->
    <script type="text/javascript">
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function () {
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });

        function btn_code(){
            var voucher_code = document.getElementById("voucher_code").value;
            var x = document.getElementById("desc_code");
            if(voucher_code ==""){
                $("#voucher_code").focus(),
                Swal.fire({
                text: "Harap Masukkan Kode",
                icon: 'error',
                showCancelButton: false,
                confirmButtonText: "Tutup",
                confirmButtonColor: '#6a3137'
                });
                $(".swal2-modal").css('background-color', ' #FDD8AF')
            }
            else
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url : '{{URL::to('/keranjang/search_vcode')}}',
                    type:'POST',
                    data:{
                        code : voucher_code
                    },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                        $('#loader').removeClass('hidden')
                    },              
                    success: function (response){
                        if (response == 'taken'){
                            $.ajax({
                                url : '{{URL::to('/keranjang/apply_code')}}',
                                type: 'POST',
                                data:{
                                    code : voucher_code
                                },
                                success: function (response){
                                $( '#accordion' ).html(response);
                                $('#collapse-4').addClass('show');
                                var totpesan_val_code = document.getElementById("total_pesan_val_code").value;
                                var voucher_no = document.getElementById("total_novoucher_val_code").value;
                                $( '#voucher_code_hide' ).val(voucher_code);
                                $( '#voucher_code_hide_modal' ).val(voucher_code);
                                $( '#total_pesan_val' ).val(totpesan_val_code);
                                $( '#total_novoucher_val' ).val(voucher_no);
                                //x.style.display = "block";
                                var objDiv = document.getElementById("collapse-4");
                                objDiv.scrollTop = objDiv.scrollHeight;
                                },
                                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                $('#loader').addClass('hidden')
                                }
                            });
                        }
                        else if (response == 'full_uses'){
                            $('#loader').addClass('hidden'),
                            $("#voucher_code").focus(),
                                Swal.fire({
                                text: "Maaf, kode tidak dapat gunakan,karena sudah mencapai batas maximum penggunaan",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: "Tutup",
                                confirmButtonColor: '#6a3137'
                                });
                            $(".swal2-modal").css('background-color', ' #FDD8AF')
                        }
                        else if(response == 'not_taken'){
                            $('#loader').addClass('hidden'),
                            $("#voucher_code").focus(),
                                Swal.fire({
                                text: "Kode Tidak Cocok",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: "Tutup",
                                confirmButtonColor: '#6a3137'
                                });
                            $(".swal2-modal").css('background-color', ' #FDD8AF')
                        }
                    },
                    error: function (response) {
                    console.log('Error:', response);
                    }
                });
            }
        }

        function reset_promo(){
            var x = document.getElementById("desc_code");
            $('#loader').removeClass('hidden');
            $.ajax({
                url : '{{URL::to('/home_cart')}}',
                type : 'GET',
                success: function (response) {
                // We get the element having id of display_info and put the response inside it
                $( '#accordion' ).html(response);
                $('#collapse-4').addClass('show');
                document.getElementById("voucher_code_hide_modal").value=null;
                x.style.display = "none";
                var objDiv = document.getElementById("collapse-4");
                objDiv.scrollTop = objDiv.scrollHeight;
                },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader').addClass('hidden')
                }
            });
        }

        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
        
            return false;
            return true;
        }
        
        function pesan_wa()
        {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var address = document.getElementById("address").value;
            var phone = document.getElementById("phone").value;
            var order_id = $('#order_id_cek').val();
            if (name != "" && email!="" && address !="" && phone !="" && phone.length > 9) {
                $.ajax({
                    url : '{{URL::to('/keranjang/cek_order')}}',
                    type:'POST',
                    dataType: 'json',
                    data:{
                        order_id : order_id,
                    },
                    success: function(response){
                        var len = 0;
                        $('#body_alert').empty();
                        if(response['data'] != null){
                            len = response['data'].length;
                        }

                        if(len > 0){
                            
                            for(var i=0; i<len; i++){
                                var desc = response['data'][i].description;
                                
                                var tr_str = "<li class='text-center'><small>"+desc+"</small></li>";
                                $("#body_alert").append(tr_str);
                            }
                            $("#modal_validasi").modal('show');
                        }
                        else
                        {
                            Swal.fire({
                            title: 'Memesan',
                            text: "Anda melakukan pesanan melalui whatsapp",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#4db849'
                            }).then(function(){ 
                                location.reload();
                            });
                        }
                    }
                });
                /*
                Swal.fire({
                    title: 'Memesan',
                    text: "Anda melakukan pesanan melalui whatsapp",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: "Ok",
                    confirmButtonColor: '#4db849'
                    }).then(function(){ 
                        location.reload();
                    });*/
            }else{
                alert('Anda harus mengisi data dengan lengkap  & benar !');
            }
        }
        
        function button_minus(id)
        {   
            var jumlah = $('#jmlbrg_'+id).val();
            var jumlah = parseInt(jumlah) - 1;
            
            // AMBIL NILAI HARGA
            var harga = $('#harga'+id).val();
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah;

            if (jumlah < 0) {
                alert('Jumlah Tidak Boleh Kurang dari nol');
                }
                else 
                {
                    $('#jmlbrg_'+id).val(jumlah);
                    $('#show_'+id).text(jumlah);
                    var Product_id = $('#Product_id'+id).val();
                    var quantity = $('#quantity_add'+id).val();
                    var price = $('#harga'+id).val();
                    var voucher_code_hide = document.getElementById("voucher_code_hide").value;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                        $.ajax({
                            url : '{{URL::to('/keranjang/min_order')}}',
                            type:'POST',
                            data:{
                                Product_id : Product_id,
                                quantity : quantity,
                                price : price
                            },
                            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                $('#loader').removeClass('hidden')
                            },              
                            success: function (data) {
                            //console.log(data);
                            //$('#'+id).val(jumlah);
                            //$('#show_'+id).html(jumlah);
                            //$('#productPrice'+id).text(harga);
                                if(voucher_code_hide !=""){
                                    $.ajax({
                                        url : '{{URL::to('/keranjang/apply_code')}}',
                                        type: 'POST',
                                        data:{
                                            code : voucher_code_hide
                                        },
                                        success: function (response){
                                        $( '#accordion' ).html(response);
                                        //$('#collapse-4').addClass('show');
                                        //$( '#total_kr_' ).html(response);
                                        var total_novoucher_val = $('#total_novoucher_val_code').val();
                                        $('#total_novoucher_val').val(total_novoucher_val);
                                        $('#voucher_code_hide').val(voucher_code_hide);
                                        $('#voucher_code_hide_modal').val(voucher_code_hide);
                                        },
                                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                        $('#loader').addClass('hidden')
                                        }
                                    });
                                }
                                else{
                                    $.ajax({
                                        url : '{{URL::to('/home_cart')}}',
                                        type : 'GET',
                                        success: function (response) {
                                        // We get the element having id of display_info and put the response inside it
                                        $( '#accordion' ).html(response);
                                        },
                                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                            $('#loader').addClass('hidden')
                                        }
                                    });
                                }
                            },
                            
                            error: function (data) {
                            console.log('Error:', data);
                            }
                        });
            }
        }

        function button_plus(id)
        {
            var jumlah = $('#jmlbrg_'+id).val();
            var jumlah = parseInt(jumlah) + 1;

            var stock = $('#stock'+id).val();
            // AMBIL NILAI HARGA
            var harga = $('#harga'+id).val();
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah;
            // alert(jumlah)
            if (jumlah < 0) {
            alert('Jumlah Tidak Boleh kurang dari nol')
            } 
            else if (jumlah > stock){
                Swal.fire({
                text: "Maaf, stok produk tidak mencukupi",
                icon: 'info',
                showCancelButton: false,
                confirmButtonText: "Tutup",
                confirmButtonColor: '#6a3137'
                });
                $(".swal2-modal").css('background-color', ' #FDD8AF')
            }
            else
            {
                $('#jmlbrg_'+id).val(jumlah);
                $('#show_'+id).html(jumlah);
                var Product_id = $('#Product_id'+id).val();
                var quantity = $('#quantity_add'+id).val();
                var price = $('#harga'+id).val();
                var voucher_code_hide = document.getElementById("voucher_code_hide").value;
                $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                $.ajax({
                    url : '{{URL::to('/keranjang/simpan')}}',
                    type:'POST',
                    data:{
                        Product_id : Product_id,
                        quantity : quantity,
                        price : price
                    },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                        $('#loader').removeClass('hidden')
                    },              
                    success: function (data){
                        //console.log(data);
                        //$('#'+id).val(jumlah);
                        //$('#show_'+id).html(jumlah);
                        //$('#productPrice'+id).text(harga);
                        if(voucher_code_hide !=""){
                            $.ajax({
                                url : '{{URL::to('/keranjang/apply_code')}}',
                                type: 'POST',
                                data:{
                                    code : voucher_code_hide
                                },
                                success: function (response){
                                $( '#accordion' ).html(response);
                                //$('#collapse-4').addClass('show');
                                //$( '#total_kr_' ).html(response);
                                var total_novoucher_val = $('#total_novoucher_val_code').val();
                                $('#total_novoucher_val').val(total_novoucher_val);
                                $('#voucher_code_hide').val(voucher_code_hide);
                                $('#voucher_code_hide_modal').val(voucher_code_hide);
                                },
                                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                $('#loader').addClass('hidden')
                                }
                            });
                        }
                        else{
                            $.ajax({
                                url : '{{URL::to('/home_cart')}}',
                                type : 'GET',
                                success: function (response) {
                                // We get the element having id of display_info and put the response inside it
                                $('#accordion' ).html(response);
                                },
                                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                    $('#loader').addClass('hidden')
                                }
                            });
                        }                                
                    },
                    
                    error: function (data) {
                    console.log('Error:', data);
                    }
                });
            }
        }

        function button_minus_kr(id)
        {   
            var jumlah = $('#jmlkr_'+id).val();
            var jumlah = parseInt(jumlah) - 1;

            // AMBIL NILAI HARGA
            var harga = $('#harga_kr'+id).val();
            var harga = parseInt(harga) * jumlah;

            //AMBIL NILAI TOTAL
            var totalkr = $('#tt_'+id).val();
            var totalkr = parseInt(totalkr) - harga;
            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah;

            if (jumlah<1) {
            alert('Jumlah order minimal 1')
            } else {
                $('#jmlbrg_'+id).val(jumlah);
                $('#show_'+id).html(jumlah);
                $('#jmlkr_'+id).val(jumlah);
                $('#show_kr_'+id).html(jumlah);
                $('#productPrice_kr'+id).text(harga);
                $('#totalKr_'+id).text(totalkr);
                var id_detil = $('#id_detil'+id).val();
                var order_id = $('#order_id'+id).val();
                var price = $('#harga_kr'+id).val();
                var id_detil = $('#id_detil'+id).val();
                var order_id = $('#order_id'+id).val();
                var price = $('#harga_kr'+id).val();
                var tot =  parseInt($('#total_kr_val').val()) - parseInt($('#harga_kr'+id).val());
                var tot_val = tot;
                var	number_string = tot.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                var voucher_code_hide = document.getElementById("voucher_code_hide").value;
                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                tot = "Rp. " + rupiah;
                $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url : '{{URL::to('/keranjang/kurang')}}',
                            type:'POST',
                            data:{
                                id_detil : id_detil,
                                order_id : order_id,
                                price : price
                            },
                            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                $('#loader').removeClass('hidden')
                            },              
                            success: function (data) {
                                $('#quantity_delete'+id).val(jumlah);
                                $('#total_kr_').html(tot);
                                $('#total_kr_val').val(tot_val);
                                $('#total_pesan_val').val(tot_val);
                                $('#total_pesan_val_hide').val(tot_val);
                                if(voucher_code_hide !=""){
                                    $.ajax({
                                        url : '{{URL::to('/keranjang/apply_code')}}',
                                        type: 'POST',
                                        data:{
                                            code : voucher_code_hide
                                        },
                                        success: function (response){
                                        $( '#accordion' ).html(response);
                                        $('#collapse-4').addClass('show');
                                        //$( '#total_kr_' ).html(response);
                                        var total_novoucher_val = $('#total_novoucher_val_code').val();
                                        $('#total_novoucher_val').val(total_novoucher_val);
                                        $('#voucher_code_hide').val(voucher_code_hide);
                                        $('#voucher_code_hide_modal').val(voucher_code_hide);
                                        },
                                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                        $('#loader').addClass('hidden')
                                        }
                                    });
                                }
                                else{
                                    $.ajax({
                                        url : '{{URL::to('/home_cart')}}',
                                        type : 'GET',
                                        success: function (response) {
                                        // We get the element having id of display_info and put the response inside it
                                        //$( '#accordion' ).html(response);
                                        //$('#collapse-4').addClass('show');
                                        },
                                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                            $('#loader').addClass('hidden')
                                        }
                                    });
                                }
                            },
                            
                            error: function (data) {
                            console.log('Error:', data);
                            }
                        });

            }
        }

        function button_plus_kr(id)
        {
            var jumlah = $('#jmlkr_'+id).val();
            var jumlah = parseInt(jumlah) + 1;

            var stock = $('#stock'+id).val();
            // AMBIL NILAI HARGA
            var harga = $('#harga_kr'+id).val();
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah;
            
            // alert(jumlah)
            if (jumlah < 1) {
            alert('Jumlah order minimal 1')
            }
            else if (jumlah > stock){
                Swal.fire({
                text: "Maaf, stok produk tidak mencukupi",
                icon: 'info',
                showCancelButton: false,
                confirmButtonText: "Tutup",
                confirmButtonColor: '#6a3137'
                });
                $(".swal2-modal").css('background-color', ' #FDD8AF')
            } 
            else 
            {
                $('#jmlbrg_'+id).val(jumlah);
                $('#show_'+id).html(jumlah);
                $('#jmlkr_'+id).val(jumlah);
                $('#show_kr_'+id).html(jumlah);
                $('#productPrice_kr'+id).text(harga);
                //$('#totalKr_'+id).text(totalkr);
                var id_detil = $('#id_detil'+id).val();
                var order_id = $('#order_id'+id).val();
                var price = $('#harga_kr'+id).val();
                var tot = parseInt($('#harga_kr'+id).val()) + parseInt($('#total_kr_val').val());
                var tot_val = tot;
                var	number_string = tot.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                var voucher_code_hide = document.getElementById("voucher_code_hide").value;
                //var total_pesan_val_hide = document.getElementById("total_pesan_val_hide").value;
                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                tot = "Rp. " + rupiah;
                $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url : '{{URL::to('/keranjang/tambah')}}',
                            type:'POST',
                            data:{
                                id_detil : id_detil,
                                order_id : order_id,
                                price : price
                            },
                            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                $('#loader').removeClass('hidden')
                            },              
                            success: function (data) {
                                $('#quantity_delete'+id).val(jumlah);
                                $('#total_kr_').html(tot);
                                $('#total_kr_val').val(tot_val);
                                $('#total_pesan_val').val(tot_val);
                                //$('#total_novoucher_val').val(total_pesan_val_hide);
                                $('#total_pesan_val_hide').val(tot_val);
                                if(voucher_code_hide !=""){
                                    $.ajax({
                                        url : '{{URL::to('/keranjang/apply_code')}}',
                                        type: 'POST',
                                        data:{
                                            code : voucher_code_hide
                                        },
                                        success: function (response){
                                        $( '#accordion' ).html(response);
                                        $('#collapse-4').addClass('show');
                                        var total_novoucher_val = $('#total_novoucher_val_code').val();
                                        //$( '#total_kr_' ).html(response);
                                        $('#total_novoucher_val').val(total_novoucher_val);
                                        $('#voucher_code_hide').val(voucher_code_hide);
                                        $('#voucher_code_hide_modal').val(voucher_code_hide);
                                        },
                                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                        $('#loader').addClass('hidden')
                                        }
                                    });
                                }
                                else{
                                    $.ajax({
                                        url : '{{URL::to('/home_cart')}}',
                                        type : 'GET',
                                        
                                        success: function (response) {
                                        // We get the element having id of display_info and put the response inside it
                                        //$( '#accordion').html(response);
                                        //$('#collapse-4').addClass('show');
                                        },
                                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                            $('#loader').addClass('hidden')
                                        }
                                    });
                                }
                                
                            },
                            error: function (data) {
                            console.log('Error:', data);
                            }
                        });
            }
        }

        function delete_kr(id)
        {   
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var quantity_delete = $('#quantity_delete'+id).val();
                var quantity_delete = parseInt(quantity_delete);
                var jumlah = $('#jmlbrg_'+id).val();
                var jumlah = parseInt(jumlah) - quantity_delete;
                var order_id_delete = $('#order_id_delete'+id).val();
                var price_delete = $('#price_delete'+id).val();
                var product_id_delete = $('#product_id_delete'+id).val();
                var id_delete = $('#id_delete'+id).val();
                var price = $('#harga'+id).val();
                var voucher_code_hide = document.getElementById("voucher_code_hide").value;
                $.ajax({
                    url : '{{URL::to('/keranjang/delete')}}',
                    type:'POST',
                    data:{
                        id : id_delete,
                        product_id : product_id_delete,
                        order_id : order_id_delete,
                        quantity : quantity_delete,
                        price : price_delete
                    },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                        $('#loader').removeClass('hidden')
                    },              
                    success: function (data) {
                    //console.log(data);
                    //$('#'+id).val(jumlah);
                    $('#jmlbrg_'+id).val(jumlah);
                    $('#show_'+id).html(jumlah);
                    //$('#productPrice'+id).text(harga);
                    if(voucher_code_hide !=""){
                        $.ajax({
                            url : '{{URL::to('/keranjang/apply_code')}}',
                            type: 'POST',
                            data:{
                                code : voucher_code_hide
                            },
                            success: function (response){
                            $( '#accordion' ).html(response);
                            $('#collapse-4').addClass('show');
                            //$( '#total_kr_' ).html(response);
                            var total_novoucher_val = $('#total_novoucher_val_code').val();
                            $('#total_novoucher_val').val(total_novoucher_val);
                            $('#voucher_code_hide').val(voucher_code_hide);
                            $('#voucher_code_hide_modal').val(voucher_code_hide);
                            },
                            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                            $('#loader').addClass('hidden')
                            }
                        });
                    }else{
                            $.ajax({
                                url : '{{URL::to('/home_cart')}}',
                                type : 'GET',
                                success: function (response) {
                                // We get the element having id of display_info and put the response inside it
                                $( '#accordion' ).html(response);
                                $('#collapse-4').addClass('show');
                                },
                                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                    $('#loader').addClass('hidden')
                                }
                            });
                        }
                    },
                    
                    error: function (data) {
                    console.log('Error:', data);
                    }
            });
        }

        function show_modal()
        {
            //$( "#collapse-4" ).load(window.location.href + " #collapse-4" );
            var order_id = $('#order_id_cek').val();
            var total_pesan_val_hide = $('#total_pesan_val_hide').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url : '{{URL::to('/keranjang/cek_order')}}',
                type:'POST',
                dataType: 'json',
                data:{
                    order_id : order_id,
                },
                success: function(response){
                    var len = 0;
                    $('#body_alert').empty();
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        
                        for(var i=0; i<len; i++){
                            var desc = response['data'][i].description;
                            
                            var tr_str = "<li class='text-center'><small>"+desc+"</small></li>";
                            $("#body_alert").append(tr_str);
                        }
                        $("#modal_validasi").modal('show');
                    }
                    else
                    {
                        $("#my_modal_content").modal('show');
                        $('#total_pesan_val').val(total_pesan_val_hide);
                        $('#order_id_pesan').val(order_id);
                        //$("#my_modal_content_ajax").modal('show');
                        //$("#my_modal_content_ajax").modal('show');
                    }
                }
            });
        }

        $(document).ready(function() {  
            $('#btn-yes').on('click', function(){
                var id_modal = $("#modal-input-id").val();
                Swal.fire('Yes!');
            });
        });
        
        window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
          });
        }, 4000);
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-183852861-1');
    </script>
</body>

</html>