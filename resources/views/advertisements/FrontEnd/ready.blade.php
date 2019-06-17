@include('drivers.FrontEnd.topbar')
<div class="container">
    <div class="row row-master"></div>
        <div class="login-div">
            <p class="textclr login-div">{{$ads->city}}? Nice! <br> Chauffeurx is available there!</p>
            <center>
                @include('flash::message')
                    <p class="loginAnchor login-div">We're Offering u $10 in ad Budget to start advertising on ChauffeurX <br/>
                    This can display your ads to 200 customers driving to your location </p>
                <a href="{{url('advertisement/create')}}" class="btn btn-primary ready-btn">Create my first ad</a>
            </center>
        </div>
</div>
<script>
    $(function () {
        if (($('.alert-success').contents().length  != 0))
        {
            $('.alert-success').hide();
            $.toast({
                heading: 'Success',
                text: $('.alert-success').text(),
                icon: 'success',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            })

        }
        if (($('.alert-danger').contents().length  != 0))
        {
            $('.alert-danger').hide();
            $.toast({
                heading: 'Failed',
                text: $('.alert-danger').text(),
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            })

        }
    });
</script>