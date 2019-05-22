
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ChauffeurX | Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('public/favicon_package_v0.16/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('public/favicon_package_v0.16/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/favicon_package_v0.16/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('public/favicon_package_v0.16/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('public/favicon_package_v0.16/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @include('drivers.FrontEnd.topbar')
    <style>
        .help-block1
        {
            color: red;
        }
        #email
        {
            display: none;
        }
        #psw
        {
            display: none;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    @include('flash::message')
    <div class="login-logo">
        {{--<a href="{{ url('/home') }}"><b>InfyOm </b>Generator</a>--}}
    </div>

    <!-- /.login-logo -->
    <div class="login-box-body">
        <center>
            <form method="post" action="{{ url('/login') }}">
            {!! csrf_field() !!}

            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control1" id="email1" name="email" value="{{ old('email') }}" placeholder="Your Email" onchange="">
                <strong>
                    <p id="email" class="help-block1">Email is Required</p>
                </strong>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>
                            {{ $errors->first('email') }}
                        </strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" id="psw1" class="form-control1" placeholder="Your Password" name="password" onchange="">
                <strong>
                    <p id="psw" class="help-block1">Password is Required</p>
                </strong>

            @if ($errors->has('password'))
                    <span class="help-block">
                    <strong>
                        {{ $errors->first('password') }}
                    </strong>
                </span>
                @endif

            </div>
            <div class="form-group">
                <button type="submit" id="btnLogin" class="btn btn-primary btn-auth" onclick="validate()">Login</button>
            </div>
            <center>
                <div class="col-md-12">
                    <div class="g-recaptcha" data-sitekey="{{$siteKey}}"></div>
                    {{--<input type="hidden" name="recaptcha_response" id="recaptchaResponse">--}}
                </div>
            </center>

        <div class="loginForgot">
            <a class="loginAnchor" href="{{ url('/password/reset') }}">I forgot my password</a><br>
            <a href="{{url('register')}}" class="text-center loginAnchor">Do you want to drive on ChauffeurX?</a>
        </div>
        </form>
        </center>


    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
    function validate() {
        var email = $('#email1').val();
        var psw = $('#psw1').val();
        if (email == '')
        {
            $('#btnLogin').prop('type','button');
            $('#email').show();
        }
        else
        {
            $('#btnLogin').prop('type','submit');
            $('#email').hide();
        }
        if (psw == '')
        {
            $('#btnLogin').prop('type','button');
            $('#psw').show();
        }
        else
        {
            $('#btnLogin').prop('type','submit');
            $('#psw').hide();
        }
    }
</script>
</body>
</html>
