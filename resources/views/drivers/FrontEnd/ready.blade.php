@include('drivers.FrontEnd.topbar')
<div class="container">
        <div class="login-div">
            <center>
                @include('flash::message')
                    <p class="loginAnchor">We received Your Application <br/>
                    Our team will Review it within 2 bussiness days and get back to you</p>
                    <p class="loginAnchor">If you are approved, You will receive an email at<br/>
                    <b><i>{{$driver->email}}</i></b></p> <br/>
                <button type="button" class="btn btn-primary ready-btn">Get ready</button>
            </center>
        </div>
</div>