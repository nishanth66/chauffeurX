<html>
<head>
    <title>ChauffeurX</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('public/favicon_package_v0.16/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('public/favicon_package_v0.16/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/favicon_package_v0.16/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('public/favicon_package_v0.16/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('public/favicon_package_v0.16/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/toast.css')}}" rel="stylesheet">
    <script src="{{asset('public/js/toast.js')}}"></script>
    <style>
        .header{
            background-color: #4D68B0;
            position: fixed;
            top: 0;
            height: 75px;
            z-index: 2;
            width: 100%;
        }
        .logo
        {
            height: 75px;
        }
        .align{
            align-items: center;
            justify-content: center;
            display: flex;
        }
        input::placeholder {
            color: #4D68B0 !important;
        }
        .textclr{
            color: #4D68B0 !important;
            text-align: center;
        }
        .next-btn{
            padding: 0.3rem 4rem;
            font-size: larger;
            width: 75%;
        }
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .alert{
            display: none !important;
        }
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row header">
        <img src="{{asset('public/image/chauffeurX.jpg')}}" class="logo">
    </div>
</div>