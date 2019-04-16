@include('drivers.FrontEnd.topbar')
<style>
    .qw{
        padding: 10px;
        border: 1px solid #4D68B0;
        width: 35px;
        height: 35px;
        text-align: center;
        font-size: 20px;
        border-radius: 10px;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
</style>
<link href="{{asset('public/css/pin.css')}}" rel="stylesheet">
{{--<script src="{{asset('public/js/pin.js')}}"></script>--}}

<div class="container-fluid">
    <div class="col-md-12 align">
        <div class="col-md-7 login-div">
            @include('flash::message')
            <div class="message">We sent a verification code to your email and phone.<br> Please type this code below</div>
            <form method="post" action="{{url('driver/verify')}}">
                <div class="wrapper">
                    @include('flash::message')
                    <hr>
                    <p class="message"><b>Email Verification Code</b></p>

                        {{csrf_field()}}
                    <input type="hidden" name="phone" value="{{$driver->phone}}">
                    <input type="hidden" name="email" value="{{$driver->email}}">
                    <input type="hidden" name="driverid" value="{{$driver->id}}">
                    <input type="hidden" name="phone_otp" id="phone1">
                    <input type="hidden" name="email_otp" id="email1">
                    <center>
                        <input class="qw" type="number" id="1" onkeyup="moveOnMax(this,'2')"  onKeyPress="if(this.value.length == 1) return false;"/>
                        <input class="qw" type="number" id="2" onkeyup="moveOnMax(this,'3')"  onKeyPress="if(this.value.length == 1) return false;"/>
                        <input class="qw" type="number" id="3" onkeyup="moveOnMax(this,'4')"  onKeyPress="if(this.value.length == 1) return false;"/>
                        <input class="qw" type="number" id="4" onkeyup="moveOnMax(this,'5')" onKeyPress="if(this.value.length == 1) return false;"/>
                        <input class="qw" type="number" id="5" onkeyup="moveOnMax(this,'6')" onKeyPress="if(this.value.length == 1) return false;"/>
                        <input class="qw" type="number" id="6" onkeyup="getEmailValue()" onKeyPress="if(this.value.length == 1) return false;"/>
                    </center>
                    <hr>
                    <p class="message"><b>Phone Verification Code</b></p>
                    <center>
                        <input class="qw" type="text" id="11" onkeyup="moveOnMax(this,'22')" onKeyPress="if(this.value.length == 1) return false;"/>
                        <input class="qw" type="text" id="22" onkeyup="moveOnMax(this,'33')" onKeyPress="if(this.value.length == 1) return false;"/>
                        <input class="qw" type="text" id="33" onkeyup="moveOnMax(this,'44')" onKeyPress="if(this.value.length == 1) return false;"/>
                        <input class="qw" type="text" id="44" onkeyup="moveOnMax(this,'55')" onKeyPress="if(this.value.length == 1) return false;"/>
                        <input class="qw" type="text" id="55" onkeyup="moveOnMax(this,'66')" onKeyPress="if(this.value.length == 1) return false;"/>
                        <input class="qw" type="text" id="66" onkeyup="getPhoneValue()" onKeyPress="if(this.value.length == 1) return false;"/>
                    </center>
                </div>
                <center>
                    <button type="submit" class="btn btn-primary btn-next">Next</button>
                </center>
            </form>

            <div class="message">
                You didn't receive the OTP?
                <br>
                <a href="{{url('driver/resendOtp')}}" class="loginAnchor">Click to send it again</a>
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
    function getPhoneValue() {
//        alert($('#1').val());
        var code = $('#11').val()+$('#22').val()+$('#33').val()+$('#44').val()+$('#55').val()+$('#66').val();
//        console.log(code);
        $('#phone1').val(code);
    }
</script>