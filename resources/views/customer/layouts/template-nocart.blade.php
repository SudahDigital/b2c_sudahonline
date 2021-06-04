<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Mega Cools | @yield('title')</title>

    <link rel="icon" href="{{ asset('assets/image/LOGO MEGACOOLS_DEFAULT.png')}}" type="image/x-icon">
    <!-- Bootstrap CSS CDN -->
    <link href="//db.onlinewebfonts.com/c/3dd6e9888191722420f62dd54664bc94?family=Myriad+Pro" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" >
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style_cools-r_1.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive_cools-r_4.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css')}}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <!-- Font Awesome JS -->
    <script src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-183852861-1"></script>
    <style type="text/css">
        /*[class^='select2'] {
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
        }*/

        .alert{
            position:fixed;
            top:5%; 
            width:50%; 
            z-index:9999; 
            margin: 0 auto; 
            background: rgba(0, 0, 0, 0.7); 
            border:none; 
            color:#ffffff; 
            font-weight:bold;
        }
        
        .select2-container--default .select2-selection--single{
            padding:4px;
            outline: none;
            height: 37px;
            font-weight: 500;
            font-size: 1em; 
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 4px;
            right: 4px;
            width: 25px;
        }

        .select2-search__field{
            outline:none;
        }

        .select2-results { 
            background:transparent;
            font-weight: 600;
        }

       
        

        #LocationForm .modal-dialog-full-width {
            position:absolute;
            right:0;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            max-width:none !important;
        }

        #LocationForm .modal-content-full-width  {
            height: auto !important;
            min-height: 100% !important;
            border-radius: 0 !important;
            background-color: #1A4066 !important 
        }

        .borderless td, .borderless th {
            border: none;
        }
    
        .paddles {
        }

        .paddle {
            position: absolute;
            right: 0;
            top:35%;
            color: #fff;
            transition: all 0.4s;
            background: #000000;
            opacity: 0.4;
            border-radius: 50px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            z-index: 1;
            outline: none;
            border:none;
            cursor: pointer;
        }
        
        .paddle:hover {
            background: #6a3137;
            color: #fff;
        }
        
        .left-paddle {
            left: 0;
        }
        .right-paddle {
            right: 0;
        }
        
        .paddles_hide {
            display: none;
        }

        

        .row::-webkit-scrollbar {
            height: 12px;
        }
        /* line 17, sass/page/_home.scss */
        .row::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }
        /* line 24, sass/page/_home.scss */
        .row::-webkit-scrollbar-thumb {
            -webkit-border-radius: 10px;
            border-radius: 10px;
            background: #6a3137;
            -webkit-box-shadow: inset 0 0 6px #FDD8AF;
        }
        /* line 30, sass/page/_home.scss */
        .row::-webkit-scrollbar-thumb:window-inactive {
            background: rgba(255, 0, 0, 0.4);
        }
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
            opacity : 0.9;
        }

        .preloader .loading {
            position: absolute;
            left: 53%;
            top: 50%;
            transform: translate(-50%,-50%);
            font: 14px arial;
        }

        #fvpp-blackout {
            display: none;
            z-index: 9997;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: #000;
            opacity: 0.8;
        }

        #my-welcome-message {
            display: none;
            z-index: 9998;
            position: fixed;
            border-radius: 10px;
            width: 42%;
            left: 29%;
            top: 5%;
            padding: 0;
            background: #FDD8AF;
            box-shadow: 5px 10px 18px #0000;
        }

        .button_welcome {
            background: linear-gradient(to bottom, #6a3137, #6a3137); 
            color:white; 
            padding: 5px 15px; 
            border:none; 
            box-shadow: 2px 2px 2px grey; 
            border-radius: 14px;
            font-size: 15px;
            font-weight: 800; 
            position: absolute;
            top: 70px;
            right: 20px;
        }

        .button_welcome:hover {
            outline:0px !important;
            -webkit-appearance:none;
            -webkit-transform: translateY(-3px);
            transform: translateY(-3px);
            box-shadow: 0 0.3rem 1rem rgba(0, 0, 0, 0.3); 
        }

        @media (max-width: 2560px){
            .button_welcome {
                font-size: 34px;
                padding: 12px 26px;
                top: 42rem;
                right: 12%;
                font-weight: 600;
                border-radius: 20px;
            }

            #my-welcome-message {
                width: 42%;
                left: 29%;
                top: 5%;
            }
        }

        @media (max-width: 1920px){
            .button_welcome {
                font-size: 25px;
                padding: 10px 25px;
                top: 32rem;
                right: 12%;
                font-weight: 600;
                border-radius: 17px;
            }

            #my-welcome-message {
                width: 42%;
                left: 29%;
                top: 5%;
            }
        }

        @media (max-width: 1440px){
            .button_welcome {
                font-size: 21px;
                padding: 10px 17px;
                top: 24rem;
                right: 10%;
                font-weight: 600;
                border-radius: 15px;
            }

            #my-welcome-message {
                width: 42%;
                left: 29%;
                top: 5%;
            }
        }

        @media (max-width: 1366px){
            .button_welcome {
                font-size: 19px;
                padding: 10px 17px;
                top: 22.4rem;
                right: 10%;
                font-weight: 600;
            }

            #my-welcome-message {
                width: 42%;
                left: 29%;
                top: 5%;
            }
        }

        @media (max-width: 1024px){
            .button_welcome {
                font-size: 15px;
                padding: 10px 17px;
                top: 17rem;
                right: 9%;
                font-weight: 600;
            }

            #my-welcome-message {
                width: 42%;
                left: 29%;
                top: 10%;
            }
        }

        @media (max-width: 768px){
            .button_welcome {
                font-size: 15px;
                padding: 10px 17px;
                top: 18.2rem;
                right: 9.5%;
                font-weight: 600;
                border-radius: 14px;
            }

            #my-welcome-message {
                width: 60%;
                left: 20%;
                top: 20%;
            }
        }

        @media (max-width: 600px){
            .button_welcome {
                font-size: 15px;
                padding: 7px 18px;
                top: 27rem;
                right: 13%;
                font-weight: 600;
            }

            #my-welcome-message {
                width: 90%;
                left: 5%;
                top: 5%;
            }
            
        }

        @media (max-width: 480px){
            .button_welcome {
                font-size: 12px;
                padding: 7px 15px;
                top: 21.5rem;
                right: 13%;
                font-weight: 600;
            }

            #my-welcome-message {
                top: 2%;
            }
        }

        @media (max-width: 425px){
            .button_welcome {
                font-size: 11px;
                padding: 7px 15px;
                top: 19rem;
                right: 12%;
                font-weight: 600;
            }

            #my-welcome-message {
                width: 90%;
                left: 5%;
                top: 5%;
            }
        }

        @media (max-width: 411px){
            .button_welcome {
                font-size: 11px;
                padding: 7px 14px;
                top: 18.5rem;
                right: 12%;
                font-weight: 600;
            }
        }

        @media (max-width: 384px){
            .button_welcome {
                font-size: 10px;
                padding: 7px 13px;
                top: 17.2rem;
                right: 12%;
                font-weight: 600;
            }
        }

        @media (max-width: 375px){
            .button_welcome {
                font-size: 10px;
                padding: 7px 13px;
                top: 16.8rem;
                right: 12%;
                font-weight: 600;
            }
        }

        @media (max-width: 364px){
            .button_welcome {
                font-size: 10px;
                padding: 7px 12px;
                top: 16.4rem;
                right: 12%;
                font-weight: 600;
            }
        }

        @media (max-width: 338px){
            .button_welcome {
                font-size: 9px;
                padding: 7px 12px;
                top: 15.4rem;
                right: 12%;
                font-weight: 600;
            }
        }

        @media (max-width: 320px){
            .button_welcome {
                font-size: 8px;
                padding: 7px 12px;
                top: 14.5rem;
                right: 12%;
                font-weight: 600;
            }
        }
    
        #product_list .ribbon {
        position: absolute;
        left: -5px; top: -5px;
        z-index: 1;
        overflow: hidden;
        width: 200px; height: 200px;
        text-align: right;
        }

        #product_list .span-ribbon {
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

        #product_list .span-ribbon::before {
        content: "";
        position: absolute; left: 0px; top: 100%;
        z-index: -1;
        border-left: 7px solid #8F5408;
        border-right: 7px solid transparent;
        border-bottom: 7px solid transparent;
        border-top: 7px solid #8F5408;
        
        }
        
        #product_list .span-ribbon::after {
        content: "";
        position: absolute; right: 0px; top: 100%;
        z-index: -1;
        border-left: 7px solid transparent;
        border-right: 7px solid #8F5408;
        border-bottom: 7px solid transparent;
        border-top: 7px solid #8F5408;
        
        }

        @media(max-width: 768px){
            #product_list .ribbon {
            position: absolute;
            left: -5px; top: -5px;
            z-index: 1;
            overflow: hidden;
            width: 75px; height: 75px;
            text-align: right;
            }
            #product_list .span-ribbon {
            font-size: 10px;
            font-weight: bold;
            color: #FFF;
            text-transform: uppercase;
            text-align: center;
            line-height: 20px;
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            width: 100px;
            display: block;
            background: #79A70A;
            background: linear-gradient(#F79E05 0%, #8F5408 100%);
            box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
            position: absolute;
            top: 19px; left: -21px;
            }
            #product_list .span-ribbon::before {
            content: "";
            position: absolute; left: 0px; top: 100%;
            z-index: -1;
            border-left: 3px solid #8F5408;
            border-right: 3px solid transparent;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #8F5408;
            }
            #product_list .span-ribbon::after {
            content: "";
            position: absolute; right: 0px; top: 100%;
            z-index: -1;
            border-left: 3px solid transparent;
            border-right: 3px solid #8F5408;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #8F5408;
            }
        }
    </style>
    <script>
        $(document).ready(function(){
          $(".preloader").fadeOut();
        })
    </script>
</head>
<body>
    <!--preloader-->
    <div class="preloader" id="preloader">
        <div class="loading">
          <img src="{{ asset('assets/image/preloader.gif') }}" width="80" alt="preloader">
          <p style="font-weight:900;line-height:2;color:#1A4066;margin-left: -10%;">Harap Tunggu</p>
        </div>
    </div>

    <div id="loader" class="lds-dual-ring hidden overlay_ajax"><img class="hidden" src="{{ asset('assets/image/preloader.gif') }}" width="80" alt="preloader"></div>
    

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <img src="{{ asset('assets/image/sp-sidebar.png') }}" class="sidebar-dot-top-right"  
            style="" alt="sp-sidebar">
            <div class="sidebar-header">
                <a href="{{url('/') }}" >
                    @if(\Auth::user())
                        @if(\Auth::user()->avatar)
                            <img style="border-radius: 50%;" src="{{asset('storage/'.Auth::user()->avatar)}}" alt="user" />
                        @else
                        <img src="{{asset('assets/image/image-noprofile.png')}}" alt="user"/>
                        @endif
                    @endif
                </a>
                <p class="mt-4">{{\Auth::user()->name}}</p>
            </div>
            <ul class="list-unstyled components">
                <li class="">
                   <a href="{{ url('/') }}">Beranda</a>
                </li>
                <!--
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Paket</a>
                    <ul class="collapse list-unstyled page-submenu" id="pageSubmenu">
                        foreach($paket as $paket_menu)
                            <li>
                                <a href="route('home_paket', ['paket'=>$paket_menu->id] )}}" style="">$paket_menu->display_name}}</a>
                            </li>
                        endforeach
                    </ul>
                </li>
                -->
                <li>
                    <a href="{{$paket != null ? URL::route('home_paket', ['paket'=>strtolower($paket->status)]) : '' }}">Paket</a>
                </li>
                
                <li>
                   <a href="{{URL::route('profil.index')}}">Profile</a>
                </li>
                <li>
                    <a href="{{URL::route('session.clear')}}">Ubah Lokasi / Toko</a>
                 </li>
                <li>
                    <a href="{{URL::route('contact')}}">Kontak Kami</a>
                </li>
                
                <li>
                    <a href="{{URL::route('pesanan')}}">Pesanan</a>
                </li>
                
            </ul>
            @if(\Auth::user())
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <div id="log">   
                        <button class="btn logout">
                            Keluar
                        </button>
                    </div>
                </form>
             @endif
             <img src="{{ asset('assets/image/sp-sidebar-bottom.jpg') }}" class="sidebar-dot-bottom"  
             style="" alt="sp-sidebar-bottom"> 
        </nav>
        <div class="overlay"></div>

        <nav class="navbar navbar-expand-lg fixed-top" style="z-index: 1.5;">
            <div class="container">
                <button type="button" id="sidebarCollapse" class="btn button-burger-menu ">
                    <i class="fas fa-bars fa-2x d-none d-md-block d-md-none" style="color:#1A4066;"></i>
                    <i class="fas fa-bars fa-1x d-md-none" style="color:#1A4066;"></i>
                </button>
                
            </div>
        </nav>
        
        <!--content-->
        <div id="content">
            <div role="main">
                <!--
                <div class="container button-burger-menu-nocart">
                    <button type="button" id="sidebarCollapse" class="btn button-burger-menu-nocart">
                        <i class="fas fa-bars fa-2x d-none d-md-block d-md-none" style="color:#1A4066;"></i>
                        <i class="fas fa-bars fa-1x d-md-none" style="color:#1A4066;"></i>
                    </button>
                </div>
                -->
                @yield('content')
            </div>
        </div>

    </div>

    <div id="message" class="row justify-content-center"></div>
    <img src="{{ asset('assets/image/dot-top-right-profil.jpg') }}" class="dot-top-right-nocart"  
    style="" alt="dot-top-right-profil">
    <img src="{{ asset('assets/image/dot-bottom-left-profil.jpg') }}" class="dot-bottom-left-nocart"  
    style="" alt="dot-bottom-left-profil">
    <img src="{{ asset('assets/image/shape-profil-bottom.jpg') }}" class="shape-bottom-right-nocart"  
    style="" alt="shape-profil-bottom">
    
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
     
    <!--<script src="{{ asset('assets/js/jquery.firstVisitPopup.js')}}"></script>-->
    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>-->
    
    <script type="text/javascript">

        $(document).ready(function(){
            $(window).scroll(function(){
                var scroll = $(window).scrollTop();
                if (scroll > 200) {
                    $(".navbar").css("background" , "#1A4066");
                    $(".fa-bars").css("color" , "#fff");
                    $(".navbar").css("opacity" , "0.9");
                    
                }

                else{
                    $(".navbar").css("background" , "transparent");
                    $(".fa-bars").css("color" , "#1A4066");  	
                }
            })
        });

        //Select2
        $('#city_id').select2({
        placeholder: 'Pilih Kota',
        ajax: {
            url: '{{URL::to('/ajax/city')}}',
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                            id: item.id,
                            text: item.city_name
                        
                    }
                })
            };
            }
            
        }
        });

        $('#customer_id').select2({
        placeholder: 'Pilih Toko',
        ajax: {
            url: '{{URL::to('/ajax/store')}}',
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                            id: item.id,
                            text: item.store_name
                        
                    }
                })
            };
            }
            
        }
        });

        //$('#accordion').collapse('show').height('auto');

        // duration of scroll animation
        var scrollDuration = 300;
        // paddles
        var leftPaddle = document.getElementsByClassName("left-paddle");
        var rightPaddle = document.getElementsByClassName("right-paddle");
        // get items dimensions
        var itemsLength = $(".item").length;
        var itemSize = $(".item").outerWidth(true);
        // get some relevant size for the paddle triggering point
        var paddleMargin = 10;

        // get wrapper width
        var getMenuWrapperSize = function () {
            return $(".menu-wrapper").outerWidth();
        };
        var menuWrapperSize = getMenuWrapperSize();
        // the wrapper is responsive
        $(window).on("resize", function () {
            menuWrapperSize = getMenuWrapperSize();
        });
        // size of the visible part of the menu is equal as the wrapper size
        var menuVisibleSize = menuWrapperSize;

        // get total width of all menu items
        var getMenuSize = function () {
            return itemsLength * itemSize;
        };
        var menuSize = getMenuSize();
        // get how much of menu is invisible
        var menuInvisibleSize = menuSize - menuWrapperSize;

        // get how much have we scrolled to the left
        var getMenuPosition = function () {
            return $(".menu").scrollLeft();
        };

        // finally, what happens when we are actually scrolling the menu
        $(".menu").on("scroll", function () {
            // get how much of menu is invisible
            menuInvisibleSize = menuSize - menuWrapperSize;
            // get how much have we scrolled so far
            var menuPosition = getMenuPosition();

            var menuEndOffset = menuInvisibleSize - paddleMargin;

            // show & hide the paddles
            // depending on scroll position
            if (menuPosition <= paddleMargin) {
                $(leftPaddle).addClass("paddles_hide");
                $(rightPaddle).removeClass("paddles_hide");
            } else if (menuPosition < menuEndOffset) {
                // show both paddles in the middle
                $(leftPaddle).removeClass("paddles_hide");
                $(rightPaddle).removeClass("paddles_hide");
            } else if (menuPosition >= menuEndOffset) {
                $(leftPaddle).removeClass("paddles_hide");
                $(rightPaddle).addClass("paddles_hide");
            }
        });

        // scroll to left
        $(rightPaddle).on("click", function () {
            $(".menu").animate({ scrollLeft: menuInvisibleSize }, scrollDuration);
        });

        // scroll to right
        $(leftPaddle).on("click", function () {
            $(".menu").animate({ scrollLeft: "0" }, scrollDuration);
        });

        //popup first page
        $(document).ready(function(){
            $("#LocationForm").modal('show');
        });

        $('#LocationForm').on('show.bs.modal', function () {
        //geolocation
        /*if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(savePosition, positionError, {timeout:10000});
        } else {
            alert ('Geolocation is not supported by this browser')
        }
            

            // handle the error here
            function positionError(error) {
                var errorCode = error.code;
                var message = error.message;

                alert(message);
            }

            function savePosition(position) {
                        //$.post("geocoordinates.php", {lat: position.coords.latitude, lng: position.coords.longitude});
                $('#lat').val(position.coords.latitude);
                $('#lng').val(position.coords.longitude);
                //$("#LocationForm").modal('hide');    
            }*/
        });

        /*
        $(function () {
				$('#my-welcome-message').firstVisitPopup({
					cookieName : 'homepage',
					showAgainSelector: '#show-message'
				});
            });
        */ 

        //sidebar
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

        //

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
                                var totpesan_val_code = $("#total_pesan_val_code").val();
                                var voucher_no = $("#total_novoucher_val_code").val();
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

        function button_plus(id)
        {
            var jumlah = $('#jumlah'+id).val();
            var jumlah = parseInt(jumlah) + 1;

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

            harga = "Rp. " + rupiah +",-";
            
            // alert(jumlah)
            if (jumlah<1) {
            alert('Jumlah Tidak Boleh Kosong')
            } else {
            $('#jumlah'+id).val(jumlah)
            $('#show_'+id).html(jumlah)
            $('#productPrice'+id).text(harga);
            }
        }
        
        function button_minus(id)
        {
            var jumlah = $('#jumlah'+id).val();
            var jumlah = parseInt(jumlah) - 1;

            // AMBIL NILAI HARGA
            var harga = $('#harga'+id).val();;
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

            harga = "Rp " + rupiah+ ",-";

            if (jumlah<1) {
            alert('Jumlah Tidak Boleh Kurang dari 1')
            } else {
            $('#jumlah'+id).val(jumlah);
            $('#show_'+id).html(jumlah);
            $('#productPrice'+id).text(harga);
            }
        }
        /*
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
        */

        function add_tocart(id)
        {
            var Product_id = $('#'+id).val();
            var quantity = $('#jumlah'+id).val();
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
                        // UBAH FORMAT UANG INDONESIA
                       $('#message').html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Product berhasil dimasukkan ke keranjang</div>").fadeIn('slow');
                       $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                            $(".alert").slideUp(500); 
                        });
                        var	number_string = price.toString();
                        var sisa 	= number_string.length % 3;
                        var rupiah 	= number_string.substr(0, sisa);
                        var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                        if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                        }

                        price = "Rp. " + rupiah +",-";
                        $('#jumlah'+id).val(1);
                        $('#show_'+id).html(1);
                        $('#productPrice'+id).text(price);
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

            harga = "Rp. " + rupiah +",-";

            if (jumlah<1) {
            alert('Jumlah order minimal 1')
            } else {
                $('#jmlbrg_'+id).val(jumlah);
                //$('#show_'+id).html(jumlah);
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

                tot = "Rp. " + rupiah+",-";
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

            harga = "Rp. " + rupiah+",-";
            
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
                //$('#show_'+id).html(jumlah);
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

                tot = "Rp. " + rupiah+",-";
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
                    //$('#jmlbrg_'+id).val(jumlah);
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
        
        function search_order(){
            var query = $('#src_order').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{URL::to('/sales/order_search')}}',
                method:'POST',
                data:{
                        query:query,
                     },
                dataType:'json',
                success:function(data)
                {
                    $('tbody').html(data.table_data);
                    //$('#total_records').text(data.total_data);
                }
            });
        }

        function open_detail_list(order_id){
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                url : '{{URL::to('/pesanan/detail')}}',
                type:'POST',
                data:{
                    order_id : order_id,
                },
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader').removeClass('hidden')
                },              
                success: function (response){
                    $("#modalDetilList").modal('show');
                    $('#DataListOrder' ).html(response);
                },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader').addClass('hidden');
                },
                
                error: function (response) {
                console.log('Error:', response);
                }
            });
        }

    /*
        window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(".alert").slideUp(500); 
        });
        }, 6000);*/
    </script>
    <script>
        /*
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-183852861-1');
        */
    </script>
</body>

</html>