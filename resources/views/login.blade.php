<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Demo | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{!! asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!! asset('assets/bower_components/font-awesome/css/font-awesome.min.css') !!}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{!! asset('assets/bower_components/Ionicons/css/ionicons.min.css') !!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{!! asset('assets/dist/css/AdminLTE.min.css') !!}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{!! asset('assets/plugins/iCheck/square/blue.css') !!}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href=""><b>Demo</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        @if(session()->has('successMsg'))
            <div class="m-alert m-alert--outline alert alert-success alert-dismissible animated fadeIn" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <span>{{ session()->get('successMsg') }}</span>
            </div>
        @endif
        @if(session()->has('errorMsg'))
            <div class="m-alert m-alert--outline alert alert-danger alert-dismissible animated fadeIn" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <span>{{ session()->get('errorMsg') }}</span>
            </div>
        @endif
        <form action="{{ url('login') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if($errors->has('email')) <span class="text-danger"> <strong> {{ $errors->first('email') }} </strong> </span> @endif
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if($errors->has('password')) <span class="text-danger"> <strong> {{ $errors->first('password') }} </strong> </span> @endif
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <a href="{{ url('forgot-password') }}">I forgot my password</a><br>
        <a href="{{ url('user-registration') }}" class="text-center">Register a new membership</a>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{!! asset('assets/bower_components/jquery/dist/jquery.min.js') !!}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{!! asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<!-- iCheck -->
<script src="{!! asset('assets/plugins/iCheck/icheck.min.js') !!}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
</body>
</html>