@include('drivers.FrontEnd.topbar')
<style>
    .form-control{
        color: #4D68B0 !important;
    }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="{{asset('public/css/profile.css')}}">
<div class="row row-master">

</div>
<div class="container-fluid">
    <div class="col-md-12 align">
        <div class="col-md-4">
            <p class="textclr login-div"> Thanks. <br> Now tell us about you </p>
            <br>
            <center>
                <div class="col-md-12">
                    <form method="post" action="{{url('driver/profile')}}">
                        @include('flash::message')
                        {{csrf_field()}}
                        <div class="form-group">
                            <input class="form-control1" id="fname" type="text" name="first_name" value="{{$driver->first_name}}" placeholder="your first name">
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" name="middle_name" value="{{$driver->middle_name}}" placeholder="your middle name">
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" name="last_name" value="{{$driver->last_name}}" placeholder="your last name">
                        </div>
                        <div class="input-group mb-4 form-group">
                            <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">
                            <select class="form-control1 Code" id="country" onchange="myFunc()">
                            <option value="" selected disabled>Select a Country</option>
                                @foreach($array as $country)
                                    <option value="{{$country->code}}" <?php if ($code == $country->code) { echo "selected"; } ?>>{{$country->name}}({{$country->code}})</option>
                                @endforeach
                        </select>
                        </span>
                            </div>
                            <input type="hidden" name="code" value="{{$code}}" id="code">
                            <input type="text" class="form-control form-control1 country" value="{{$driver->phone}}" placeholder="Your phone" id="phoneNumberForm" name="phone" aria-describedby="basic-addon2">
                            <span id="help-block">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary next-btn" id="nextBtn">Next</button>
                        </div>
                    </form>
                </div>
            </center>
        </div>
    </div>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('select option')[0].value=$('select option:selected').val();
        $('select option')[0].innerHTML=$('select option:selected').val();
        $("select").val($('select option:selected').val());

        $('select').change(function() {
            $('select option')[0].value=$('select option:selected').val();
            $('select option')[0].innerHTML=$('select option:selected').val();
            $("select").val($('select option:selected').val());
        });
        if (($('.alert-success').contents().length != 0)) {
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
    $('#nextBtn').click(function (e) {
       if ($('#fname').val() == '')
       {
           e.preventDefault();
           $.toast({
               heading: 'Failed',
               text: "First Name is required",
               icon: 'error',
               hideAfter: 5000,
               showHideTransition: 'slide',
               loader: false
           });
           $('#fname').addClass("error");
           $('#phoneNumberForm').removeClass("error");
           return false;
       }
       if ($('#phoneNumberForm').val() == '')
       {
           e.preventDefault();
           $('#fname').removeClass("error");
           $('#phoneNumberForm').addClass("error");
           $.toast({
               heading: 'Failed',
               text: "Phone number is required",
               icon: 'error',
               hideAfter: 5000,
               showHideTransition: 'slide',
               loader: false
           });
           return false;
       }
    });
    $('#phoneNumberForm').click(function () {
        $.toast({
            heading: '',
            text: "This number is used to assign the trip. So be carefull while entering the phone number",
            icon: 'info',
            hideAfter: 5000,
            showHideTransition: 'slide',
            loader: false
        })
    });
    function myFunc()
    {
        var code = $('#country').val();
        $('#code').val(code);
    }
    function getWarning() {
        $('#help-block').show();
    }
</script>