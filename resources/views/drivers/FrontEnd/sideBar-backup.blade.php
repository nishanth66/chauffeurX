<link rel="stylesheet" href="{{asset('public/css/sideBarStyle.css')}}">
<style>
    #sidebar
    {
        overflow: hidden !important;
    }
</style>
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <center>
                @if(isset($driver->image) && $driver->image != '' || !empty($driver->image))
                    <img class="img img-responsive img-circle driverLogo" id="main-image" src="{{asset('public/avatars').'/'.$driver->image}}">
                @else
                    <img class="img img-responsive img-circle driverLogo" id="main-image" src="{{asset('public/image/faCar.png')}}">
                @endif
                <h4 class="loginAnchor driver-header-name">{{$driver_name}}</h4>
            </center>
        </div>

        <ul class="list-unstyled components">
            <li class="@if(Request::is('driver/home')) active @endif">
                <a class="loginAnchor" href="@if(Request::is('driver/home')) # @else {{url('driver/home')}} @endif">
                    <i class="fa fa-home"></i>
                    <span class="ex">Home</span>
                </a>
            </li>
            <li class="@if(Request::is('driver/editProfile')) active @endif">
                <a class="loginAnchor" href="@if(Request::is('driver/editProfile')) # @else {{url('driver/editProfile')}} @endif">
                    <i class="fa fa-user"></i>
                    <span class="ex">Edit Profile</span>
                </a>
            </li>
            <li class="@if(Request::is('driver/history')) active @endif">
                <a class="loginAnchor" href="@if(Request::is('driver/history'))  # @else {{url('driver/history')}} @endif">
                    <i class="fa fa-history"></i>
                    <span class="ex">Ride History</span>
                </a>
            </li>
            <li class="@if(Request::is('driver/upcoming')) active @endif">
                <a class="loginAnchor" href="@if(Request::is('driver/upcoming'))  # @else {{url('driver/upcoming')}} @endif">
                    <i class="fa fa-calendar"></i>
                    <span class="ex">Upcoming</span>
                </a>
            </li>
            <li class="@if(Request::is('driver/account')) active @endif">
                <a class="loginAnchor" href="@if(Request::is('driver/account'))  # @else {{url('driver/account')}} @endif">
                    <i class="fa fa-user"></i>
                    <span class="ex">Account</span>
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
        <div class="overlay"></div>