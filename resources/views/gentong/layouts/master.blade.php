<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>MT-Gentong @yield('title')</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('assets/image/'.$client_slug.'/logo-gentong-nav.png')}}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="{{asset('bsb/googleapis.css?family=Roboto:400,700&subset=latin,cyrillic-ext')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('bsb/googleapisicon.css?family=Material+Icons')}}" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('bsb/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('bsb/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Dropzone Css -->
    <link href="{{asset('bsb/plugins/dropzone/dropzone.css')}}" rel="stylesheet">

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{asset('bsb/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="{{asset('bsb/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('bsb/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="{{asset('bsb/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- Sweet Alert Css -->
    <link href="{{asset('bsb/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('bsb/css/style.css')}}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('bsb/css/themes/all-themes.css')}}" rel="stylesheet" />

    <link href="netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
</head>

<body class="theme-cyan">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#">ICE GENTONG</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <!--
                <ul class="nav navbar-nav navbar-right">
                    Call Search 
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                     #END# Call Search
                    
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
                -->
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    @if(\Auth::user())
                    <img src="{{asset('storage/'.Auth::user()->avatar)}}" width="48" height="48" alt="User" />
                    @endif
                </div>
                <div class="info-container">
                    @if(\Auth::user())
                    
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}}</div>
                        <div class="email">{{Auth::user()->email}}</div>
                        <div class="btn-group user-helper-dropdown">
                            <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                            <ul class="dropdown-menu pull-right">
                                <!--
                                <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                                <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                                <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                                <li role="separator" class="divider"></li>
                                -->
                                
                                    <form action="{{route('logoutadmin', $client_slug)}}" method="POST">
                                    @csrf   
                                        <button class="btn btn-default ">
                                                &nbsp;<i class="material-icons">input</i>
                                                &nbsp;Sign Out
                                        </button>
                                    </form>
                                    <a href="{{route('changepass')}}" class="btn btn-default">
                                        &nbsp;<i class="material-icons">settings</i>
                                        &nbsp;Change Password
                                    </a>
                                   
                                
                            </ul>
                        </div>
                    
                    @endif
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{route('home', $client_slug)}}">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    
                    @can('isSuperadmin')
                    <li class="{{request()->routeIs('users.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>Manage Users</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="{{request()->routeIs('users.index') ? 'active' : '' }}">
                                <a href="{{route('users.index', $client_slug)}}">List User</a>
                            </li>
                        </ul>
                    </li>
                    @endcan

                    <li class="{{request()->routeIs('banner.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">insert_photo</i>
                            <span>Manage Banner</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="{{request()->routeIs('banner.index') ? 'active' : '' }}">
                                <a href="{{route('banner.index', $client_slug)}}">List Slide Banner</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{request()->routeIs('categories.index') ? 'active' : ''}}">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">label</i>
                            <span>Manage Categories</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="{{request()->routeIs('categories.index') ? 'active' : '' }}">
                                <a href="{{route('categories.index', $client_slug)}}">Categories</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{request()->routeIs('products.index') ? 'active' : ''}}">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">local_drink</i>
                            <span>Manage Products</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="{{request()->routeIs('products.index') ? 'active' : '' }}">
                                <a href="{{route('products.index', $client_slug)}}">Products</a>
                            </li>
                        </ul>
                        
                    </li>

                    <li class="{{request()->routeIs('vouchers.index') ? 'active' : ''}}">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">chrome_reader_mode</i>
                            <span>Manage Vouchers</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="{{request()->routeIs('vouchers.index') ? 'active' : '' }}">
                                <a href="{{route('vouchers.index', $client_slug)}}">Vouchers</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{request()->routeIs('orders.index') ? 'active' : ''}}">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">shopping_cart</i>
                            <span>Manage Orders</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="{{request()->routeIs('orders.index') ? 'active' : '' }}">
                                <a href="{{route('orders.index', $client_slug)}}">Orders</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2020 <a href="javascript:void(0);"> Ice Gentong</a>
                </div>
                
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2><b>@yield('title')</b></h2>
                        </div>
                        <div class="body">   
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="{{asset('bsb/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{asset('bsb/plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Select Plugin Js -->
    <script src="{{asset('bsb/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{asset('bsb/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="{{asset('bsb/plugins/jquery-validation/jquery.validate.js')}}"></script>

    <!-- JQuery Steps Plugin Js -->
    <script src="{{asset('bsb/plugins/jquery-steps/jquery.steps.js')}}"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="{{asset('bsb/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="{{asset('bsb/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Dropzone Plugin Js -->
    <script src="{{asset('bsb/plugins/dropzone/dropzone.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('bsb/plugins/node-waves/waves.js')}}"></script>

    <!-- Autosize Plugin Js -->
    <script src="{{asset('bsb/plugins/autosize/autosize.js')}}"></script>

    <!-- Moment Plugin Js -->
    <script src="{{asset('bsb/plugins/momentjs/moment.js')}}"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{asset('bsb/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="{{asset('bsb/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('bsb/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('bsb/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('bsb/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('bsb/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('bsb/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('bsb/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('bsb/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('bsb/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('bsb/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('bsb/js/admin.js')}}"></script>
    <script src="{{asset('bsb/js/pages/forms/basic-form-elements.js')}}"></script>
    <script src="{{asset('bsb/js/pages/forms/form-validation.js')}}"></script>
    <script src="{{asset('bsb/js/pages/tables/jquery-datatable.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{asset('bsb/js/demo.js')}}"></script>
    <script>
        window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
        }, 3000);
    </script>
    @yield('footer-scripts')
</body>

</html>
