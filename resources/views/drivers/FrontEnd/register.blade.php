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
        .input-group>.input-group-append>.btn, .input-group>.input-group-append>.input-group-text, .input-group>.input-group-prepend:first-child>.btn:not(:first-child), .input-group>.input-group-prepend:first-child>.input-group-text:not(:first-child), .input-group>.input-group-prepend:not(:first-child)>.btn, .input-group>.input-group-prepend:not(:first-child)>.input-group-text{
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            background-color: white;
            border-color: #4d68b0;
            width: 60px;
        }

        .input-group>.custom-select:not(:first-child), .input-group>.form-control1:not(:first-child){
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }
        .input-group{
            width: 75%;
        }
        .Code{
            border: none !important;
            height: 30px !important;
            padding: 0 !important;
            width: 100% !important;
        }
        .input-group-text{
            padding: 0 !important;
        }
        .country{
            width: 50% !important;
        }
    </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        {{--        <a href="{{ url('/home') }}"><b>InfyOm </b>Generator</a>--}}
    </div>

    <div class="register-box-body">

        <center>
            <form method="post" action="{{ url('/register') }}">

            {!! csrf_field() !!}

            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control1" name="email" value="{{ old('email') }}" placeholder="Your Email">
                <input type="hidden" class="form-control1" name="status" value="1">

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

                <div class="input-group mb-2 form-group">
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">
                            <select class="form-control1 Code" id="country" onchange="myFunc()" required>
                            <option value="" selected disabled>Select a Country</option>
                                @foreach($array as $country)
                                    <option value="{{$country->code}}" <?php if ($code == $country->code) { echo "selected"; } ?>>{{$country->name}}({{$country->code}})</option>
                                @endforeach
                        </select>
                        </span>
                    </div>
                    <input type="hidden" name="code" value="{{$code}}" id="code">
                    <input type="text" class="form-control form-control1 country" placeholder="your phone" name="phone" aria-describedby="basic-addon2">
                </div>


                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control1" name="password" placeholder="Your Password">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input type="password" name="password_confirmation" class="form-control1" placeholder="Confirm password">

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
                <div class="form-group col-md-12">
                    <button class="btn btn-primary btn-reg">Signup</button>
                </div>
                <center>
                    <div class="col-md-12">
                        <div class="g-recaptcha" data-sitekey="6Lc-gZYUAAAAAExms1i-_hJmtwQJ3CFMGLdrYunM"></div>
                    </div>
                </center>
        </form>
            <div class="loginForgot">
                <a href="{{ url('/login') }}" class="text-center loginAnchor">I already have a membership</a>
            </div>

        </center>

    </div>
    <!-- /.form-box -->
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
    $(document).ready(function() {
        $('select option')[0].value=$('select option:selected').val();
        $('select option')[0].innerHTML=$('select option:selected').val();
        $("select").val($('select option:selected').val());

        $('select').change(function() {
            $('select option')[0].value=$('select option:selected').val();
            $('select option')[0].innerHTML=$('select option:selected').val();
            $("select").val($('select option:selected').val());
        });
    });
    function myFunc()
    {
        var code = $('#country').val();
//        console.log(code);
        $('#code').val(code);
    }
</script>
</body>
</html>
