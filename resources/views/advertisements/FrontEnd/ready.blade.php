@include('drivers.FrontEnd.topbar')
<div class="container">
        <div class="login-div">
            <p class="textclr login-div">{{$ads->city}}? Nice! <br> Chauffeurx is available there!</p>
            <center>
                @include('flash::message')
                    <p class="loginAnchor login-div">We're Offering u $10 in ad Budget to start advertising on ChauffeurX <br/>
                    This can display your ads to 200 customers driving to your location </p>
                <button type="button" class="btn btn-primary ready-btn">Create my first ad</button>
            </center>
        </div>
</div>