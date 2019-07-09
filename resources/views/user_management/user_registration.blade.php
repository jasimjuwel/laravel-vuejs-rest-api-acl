<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Demo | Registration</title>
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="stylesheet" href="{!! asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!! asset('assets/bower_components/font-awesome/css/font-awesome.min.css') !!}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{!! asset('assets/bower_components/Ionicons/css/ionicons.min.css') !!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{!! asset('assets/dist/css/AdminLTE.min.css') !!}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{!! asset('assets/plugins/iCheck/square/blue.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/custom_style.css') !!}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href=""><b>Demo</b></a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="{{ url('user-registration-save') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group has-feedback">
                <label for="user_name">User Name</label>
                <input type="text" name="user_name" class="form-control" placeholder="User name" autocomplete="off">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if($errors->has('user_name')) <span class="text-danger"> <strong> {{ $errors->first('user_name') }} </strong> </span> @endif
            </div>
            <div class="form-group has-feedback">
                <label for="user_name">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if($errors->has('email')) <span class="text-danger"> <strong> {{ $errors->first('email') }} </strong> </span> @endif
            </div>
            <div class="form-group has-feedback">
                <label for="user_name">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if($errors->has('password')) <span class="text-danger"> <strong> {{ $errors->first('password') }} </strong> </span> @endif
            </div>
            <div class="form-group has-feedback">
                <label for="user_name">Retype password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password" autocomplete="off">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                @if($errors->has('password_confirmation')) <span class="text-danger"> <strong> {{ $errors->first('password_confirmation') }} </strong> </span> @endif
            </div>
            <div class="form-group has-feedback">
                <label for="user_name">User Role</label>
                <select name="role_id" class="form-control role_id" id="role_id">
                    <option value="">Select Role</option>
                    @foreach($userRoleList as $value)
                        <option value="{{ $value->id }}">{{ $value->role_name }}</option>
                    @endforeach
                </select>
                @if($errors->has('role_id')) <span class="text-danger"> <strong> {{ $errors->first('role_id') }} </strong> </span> @endif
            </div>
            <div class="form-group has-feedback">
                <label for="user_name">File</label>
                <input type="file" name="user_photo" class="form-control">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <a href="{{ url('admin-login') }}" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

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
