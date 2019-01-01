<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GHC&K</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ mix('app/css/login.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="{{ route('home') }}"><b>GHC&K</b></a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Đăng Kí Tài Khoản</p>

        {!! Form::open(['route' => 'register', 'method' => 'POST']) !!}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="bussiness-info">
            <div class="form-group has-feedback">
                {!! Form::label('store-name', 'Tên cửa hàng') !!}
                {!! Form::text(
                    'Store[name]',
                    old('Store[name]'),
                    [
                        'id' => 'store-name',
                        'class' => 'form-control',
                        'placeholder' => 'Acme Inc.',
                        'required autofocus'
                    ]
                    )
                !!}
                <span class="glyphicon glyphicon-bold form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::label('full-name', 'Tên đầy đủ') !!}
                {!! Form::text(
                    'fullName[name]',
                    old('fullName[name]'),
                    [
                        'id' => 'full-name',
                        'class' => 'form-control',
                        'placeholder' => 'John Doe',
                        'required autofocus'
                    ]
                    )
                !!}
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
        </div>
            <div class="user-info">
                <div class="form-group has-feedback">
                    {!! Form::label('store-name', 'Email') !!}
                    {!! Form::email(
                            'User[email]',
                            old('User[email]'),
                            [
                                'id' => 'user-email',
                                'class' => 'form-control',
                                'placeholder' => 'john.doe@example.com',
                                'autocomplete' => 'off',
                                'required'
                            ]
                        )
                    !!}
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    {!! Form::label('store-name', 'Mật khẩu') !!}
                    {!! Form::password(
                                'User[password]',
                                [
                                    'class' => 'form-control',
                                    'placeholder' => 'Password',
                                    'required'
                                ]
                            )
                        !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    {!! Form::label('store-name', 'Xác nhận mật khẩu') !!}
                    {!! Form::password(
                                'User[password_confirmation]',
                                [
                                    'class' => 'form-control',
                                    'placeholder' => 'Confirm Password',
                                    'required'
                                ]
                            )
                        !!}
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
            </div>
        <div class="form-group no-margin">
            {!! Form::submit('Đăng Kí', ['class' => 'btn btn-primary btn-block']) !!}
        </div>
        @guest
            <div class="text-center small" style="margin-top: 1rem !important;">
                Bạn đã có tài khoản ? <a href="{{ route('login') }}">Đăng Nhập</a>
            </div>
        @endguest
        {!! Form::close() !!}

    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

<script src="{{ mix('app/js/login.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
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