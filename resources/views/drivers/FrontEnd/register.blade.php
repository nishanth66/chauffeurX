<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ChauffeurX | Registration Page</title>

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
        #cpsw
        {
            display: none;
        }
        #mpsw
        {
            display: none;
        }
    </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
    @include('flash::message')
    <div class="register-box-body">
        <center>
            <form method="post" action="{{ url('/register') }}">
            {!! csrf_field() !!}
            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control1" id="email1" name="email" value="{{ old('email') }}" placeholder="Your Email">
                <input type="hidden" class="form-control1" name="status" value="1">
                <strong>
                    <p id="email" class="help-block1">Email is Required</p>
                </strong>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control1" id="psw1" name="password" placeholder="Your Password">
                    <strong>
                        <p id="psw" class="help-block1">Password is Required</p>
                        <p id="mpsw" class="help-block1">Password doesnt match</p>
                    </strong>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input type="password" id="psw2" name="password_confirmation" class="form-control1" placeholder="Confirm password">
                <strong>
                    <p id="cpsw" class="help-block1">Password Confirmation is Required</p>
                </strong>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-12">
                <button class="btn btn-primary btn-reg" id="btnLogin" onclick="validate()">Signup</button>
            </div>

            <div class="form-group col-md-12">
                <div class="g-recaptcha" data-sitekey="{{$siteKey}}"></div>
            </div>
            </form>

            <div class="loginForgot">
                <a href="{{ url('/login') }}" class="text-center loginAnchor">I already have a membership</a>
            </div>
        </center>
    </div>
</div>
<!-- /.register-box -->
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
</script>

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
        var cpsw = $('#psw2').val();
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
        if (cpsw == '')
        {
            $('#btnLogin').prop('type','button');
            $('#cpsw').show();
        }
        else
        {
            $('#btnLogin').prop('type','submit');
            $('#cpsw').hide();
            if (psw != cpsw)
            {
                $('#btnLogin').prop('type','button');
                $('#mpsw').show();
            }
            else
            {
                $('#btnLogin').prop('type','submit');
                $('#mpsw').hide();
            }
        }
    }
    function Novalidate() {
        $('#btnLogin').prop('type','submit');
        $('#mpsw').hide();
        $('#psw').hide();
        $('#cpsw').hide();
        $('#email').hide();
    }
</script>

</body>
</html>
