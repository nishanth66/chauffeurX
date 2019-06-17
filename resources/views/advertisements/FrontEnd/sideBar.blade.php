<link rel="stylesheet" href="{{asset('public/css/sideBarStyle.css')}}">
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <center>
                @if(isset($ads->image) && $ads->image != '' || !empty($ads->image))
                    <img class="img img-responsive img-circle driverLogo" id="main-image" src="{{asset('public/avatars').'/'.$ads->image}}">
                @else
                    <img class="img img-responsive img-circle driverLogo" id="main-image" src="{{asset('public/image/component.png')}}">
                @endif
                <h4 class="loginAnchor driver-header-name">{{$name}}</h4>
            </center>
        </div>

        <ul class="list-unstyled components">
            <li class="@if(Request::is('advertisement/home') || Request::is('advertisement/edit/*')) active @endif">
                <a class="loginAnchor" href="@if(Request::is('advertisement/home')) # @else {{url('advertisement/home')}} @endif">
                    <i class="fa fa-home"></i>
                    <span class="ex">Home</span>
                </a>
            </li>
            <li class="@if(Request::is('advertisement/editProfile')) active @endif">
                <a class="loginAnchor" href="@if(Request::is('advertisement/editProfile')) # @else {{url('advertisement/editProfile')}} @endif">
                    <i class="fa fa-user"></i>
                    <span class="ex">Edit Profile</span>
                </a>
            </li>
            <li class="@if(Request::is('advertisement/create')) active @endif">
                <a class="loginAnchor" href="@if(Request::is('advertisement/create'))  # @else {{url('advertisement/create')}} @endif">
                    <i class="fa fa-plus"></i>
                    <span class="ex">Create new Ad</span>
                </a>
            </li>
            <li>
                <a class="loginAnchor" href="{!! url('/logout') !!}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    <span class="ex">Logout</span>
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </nav>

    <!-- Page Content  -->
    <div id="content">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </nav>
