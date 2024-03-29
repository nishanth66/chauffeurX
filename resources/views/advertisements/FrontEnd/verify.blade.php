@include('drivers.FrontEnd.topbar')
<link href="{{asset('public/css/pin.css')}}" rel="stylesheet">

<style>
    .qw{
        padding: 10px;
        border: 1px solid #4D68B0;
        width: 45px;
        height: 45px;
        text-align: center;
        font-size: 20px;
        border-radius: 10px;
    }
    .qw:focus{
        outline: none !important;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
    .btn-next
    {
        width: 35%;
        margin: 2.5rem 0;
        border-radius: 10px;
    }
</style>
{{--<script src="{{asset('public/js/pin.js')}}"></script>--}}

<div class="container-fluid">
    <div class="row row-master"></div>
    <div class="col-md-12 align">
        <div class="col-md-7 login-div">
            @include('flash::message')
            <div class="message">We sent a verification code to your email.<br> Please type this code below</div>
            <form method="post" action="{{url('advertisement/verify')}}">
                <div class="wrapper">
                    @include('flash::message')
                    <hr>
                    <p class="message"><b>Email Verification Code</b></p>

                        {{csrf_field()}}
                    <input type="hidden" name="email" value="{{$ads->email}}">
                    <input type="hidden" name="adsid" value="{{$ads->id}}">
                    <input type="hidden" name="email_otp" id="email1">
                    <center>
                        <input class="qw" type="number" id="1" onkeyup="moveOnMax(this,'2')"  onKeyPress="if(this.value.length == 1) return false;" />
                        <input class="qw" type="number" id="2" onkeyup="moveOnMax(this,'3')"  onKeyPress="if(this.value.length == 1) return false;" onkeydown="checkKey(this,1)"/>
                        <input class="qw" type="number" id="3" onkeyup="moveOnMax(this,'4')"  onKeyPress="if(this.value.length == 1) return false;" onkeydown="checkKey(this,2)"/>
                        <input class="qw" type="number" id="4" onkeyup="moveOnMax(this,'5')" onKeyPress="if(this.value.length == 1) return false;" onkeydown="checkKey(this,3)"/>
                        <input class="qw" type="number" id="5" onkeyup="moveOnMax(this,'6')" onKeyPress="if(this.value.length == 1) return false;" onkeydown="checkKey(this,4)"/>
                        <input class="qw" type="number" id="6" onkeyup="getEmailValue()" onKeyPress="if(this.value.length == 1) return false;" onkeydown="checkKey(this,5)"/>
                    </center>
                    {{--<hr>--}}
                </div>
                <center>
                    <button type="submit" class="btn btn-primary btn-next" id="nextBtn">Next</button>
                </center>
            </form>

            <div class="message">
                You didn't receive the OTP?
                <br>
                <a href="{{url('advertisement/resendOtp')}}" class="loginAnchor">Click to send it again</a>
            </div>
        </div>
    </div>
</div>
<script>
    moveOnMax =function (field, nextFieldID) {
        if (field.value.length == 1) {
            document.getElementById(nextFieldID).focus();
        }
    }
    function getEmailValue() {
//        alert($('#1').val());
        var code = $('#1').val()+$('#2').val()+$('#3').val()+$('#4').val()+$('#5').val()+$('#6').val();
//        console.log(code);
        $('#email1').val(code);
    }
    function checkKey(field,nextFieldID)
    {
        if ((event.keyCode == 8 || event.keyCode == 46) && $(field).val() == '')
        {
//            $(field).val('');
            document.getElementById(nextFieldID).focus();
        }
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
    $('#nextBtn').click(function () {
        if ($('#email1').val() == '')
        {
            $.toast({
                heading: 'Failed',
                text: "Verification code is empty",
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            return false;
        }
    });
</script>