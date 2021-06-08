<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>MT Gentong @yield('title')</title>
    <!-- Favicon-->
    <link rel="icon" href="{{asset('bsb/favicon.ico')}}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="{{asset('bsb/googleapis.css?family=Roboto:400,700&subset=latin,cyrillic-ext')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('bsb/googleapisicon.css?family=Material+Icons')}}" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('bsb/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('bsb/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('bsb/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('bsb/css/style.css')}}" rel="stylesheet">
</head>

<body class="login-page">

    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);"><b>ICE GENTONG</b></a>
            <small></small>
        </div>
        <div class="card">
            <div class="body">

                @yield('content')
                
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{asset('bsb/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{asset('bsb/plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('bsb/plugins/node-waves/waves.js')}}"></script>

    <!-- Validation Plugin Js -->
    <script src="{{asset('bsb/plugins/jquery-validation/jquery.validate.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('bsb/js/admin.js')}}"></script>
    <script src="{{asset('bsb/js/pages/examples/sign-in.js')}}"></script>
</body>

</html>