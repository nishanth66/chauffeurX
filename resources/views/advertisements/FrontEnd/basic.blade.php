@include('drivers.FrontEnd.topbar')
<style>
    .form-control{
        color: #4D68B0 !important;
    }
</style>
<link rel="stylesheet" href="{{asset('public/css/profile.css')}}">
<div class="container-fluid">
    <div class="row row-master"></div>
    <div class="col-md-12 align">
        <div class="col-md-4">
            <p class="textclr login-div"> Thanks. <br> Now tell us about you </p>
            <br>
            <center>
                <div class="col-md-12">
                    <form method="post" action="{{url('advertisement/profile')}}">
                        @include('flash::message')
                        {{csrf_field()}}
                        <div class="form-group">
                            <input class="form-control1" type="text" id="fname" name="fname" value="{{$ads->fname}}" placeholder="your first name" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" name="mname" value="{{$ads->mname}}" placeholder="your middle name">
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" name="lname" value="{{$ads->lname}}" placeholder="your last name">
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
                            <input type="text" class="form-control form-control1 country" id="phone" placeholder="Your phone" name="phone" aria-describedby="basic-addon2">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary next-btn" id="btnNext">Next</button>
                        </div>
                    </form>
                </div>
            </center>
        </div>
    </div>
</div>
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
    });
    function myFunc()
    {
        var code = $('#country').val();
//        console.log(code);
        $('#code').val(code);
    }
    function getWarning() {
        $('#help-block').show();
    }
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
    $('#btnNext').click(function (e) {
       if ($('#fname').val() == '')
       {
           e.preventDefault();
           $('input').removeClass('error');
           $.toast({
               heading: 'Failed',
               text: "First Name is required",
               icon: 'error',
               hideAfter: 5000,
               showHideTransition: 'slide',
               loader: false
           });
           $('#fname').addClass('error');
           return false;
       }
       else if($('#phone').val() == '')
       {
           e.preventDefault();
           $('input').removeClass('error');
           $.toast({
               heading: 'Failed',
               text: "Phone Number is required",
               icon: 'error',
               hideAfter: 5000,
               showHideTransition: 'slide',
               loader: false
           });
           $('#phone').addClass('error');
           return false;
       }
       else
       {
           $('input').removeClass('error');
       }
    });
</script>