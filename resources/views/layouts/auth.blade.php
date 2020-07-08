<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$pageTitle ?? $naturalPageTitle}} | {{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{url('/')}}">{{site_details()->name}}</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{$pageTitle ?? $naturalPageTitle}}</p>
            @yield('content')
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<script src="{{url('/vendor/jquery/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{url('/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{url('/vendor/popper/popper.min.js')}}"></script>
<script src="{{url('/vendor/adminlte/js/adminlte.min.js')}}"></script>

</body>
</html>
