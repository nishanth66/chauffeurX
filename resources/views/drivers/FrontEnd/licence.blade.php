@include('drivers.FrontEnd.topbar')
<style>
    .form-control{
        color: #4D68B0 !important;
    }
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<div class="container-fluid">
    <div class="col-md-12 align login-div">
        <div class="col-md-4">
            <center><div class="col-md-8 textclr">{{$city}}? Nice.<br>ChauffeurX is available there. <br/> Let's get you ready to drive.</div></center>
            <br>
            <center>
                <div class="col-md-12">
                    @include('flash::message')
                    <form method="post" action="{{url('driver/verifyLicence')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input class="form-control1" type="text" value="{{$driver->licence}}" name="licence" placeholder="Your Driver License Number" required>
                        </div>
                        <div class="form-group"> <!-- Date input -->
                            <input class="form-control1" value="{{$driver->licence_expire}}" id="date" name="date" placeholder="Expiry Date" readonly type="text"/>
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" maxlength="4" value="{{$driver->ssn}}" name="ssn" placeholder="the last 4 digits of your SSN" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary next-btn">Next</button>
                        </div>
                    </form>
                </div>
            </center>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
            format: 'mm/dd/yyyy',
            startDate: new Date(),
            container: container,
            todayHighlight: true,
            autoclose: true,
        };
        date_input.datepicker(options);
    })
</script>

