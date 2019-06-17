<div class="overlay" id="overlay"></div>
<div class="loader" id="loader-2">
    <span></span>
    <span></span>
    <span></span>
</div>
@include('drivers.FrontEnd.header')
@include('advertisements.FrontEnd.sideBar')
<link rel="stylesheet" href="{{asset('public/css/profile.css')}}">

<style>
    .in
    {
        display: flex !important;
    }
    .modal-dialog
    {
        margin: auto;
    }
    .pac-container {
        z-index: 10000 !important;
    }
    .modal-footer
    {
        border-top: none;
    }
    .modal-header
    {
        border-bottom: none;
    }
    .Code {
        border: none !important;
        padding: 0 !important;
        width: 100% !important;
        height: 38px !important;
    }
    .Code:focus {
        border: none !important;
        padding: 0 !important;
        width: 100% !important;
        height: 38px !important;
    }
    .input-group>.input-group-append>.btn, .input-group>.input-group-append>.input-group-text, .input-group>.input-group-prepend:first-child>.btn:not(:first-child), .input-group>.input-group-prepend:first-child>.input-group-text:not(:first-child), .input-group>.input-group-prepend:not(:first-child)>.btn, .input-group>.input-group-prepend:not(:first-child)>.input-group-text {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border: 1px solid #4d68b0;
        border-right: none;
        background-color: white;
        width: 65px;
        float: left;
    }
    .input-group
    {
        margin-left: 25%;
    }
    #content
    {
        padding: 20px;
    }
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
    .btn-next:focus{
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
    .loginAnchor
    {
        cursor: pointer;
    }

</style>

    <div class="driver-profile-details" id="driver-profile-details">
        @include('flash::message')
        <div class="row">
            <div class="col-md-3 col-sm-2 col-xs-1"></div>
            <div class="col-md-8 col-sm-8 col-xs-10">
                <form method="post" action="{{url('driver/editProfile')}}" enctype="multipart/form-data" id="editProfile">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$ads->id}}" name="adId" id="driverid">
                    <input type="hidden" value="2" name="type">
                    <div style="position: relative;">
                        @if(isset($ads->image) && $ads->image != '' || !empty($ads->image))
                            <img id="image" src="{{asset('public/avatars').'/'.$ads->image}}" class="img-circle driver-edit-logo">
                        @else
                            <img id="image"  src="{{asset('public/image/component.png')}}" class="img-circle driver-edit-logo">
                        @endif
                    </div>
                    <i class="fa fa-pencil faPencil" onclick="triggerUpload()"></i>
                    <input type="file" name="image" id="license"  style="display: none;" accept="image/*" onchange="saveImg(this);">
                </form>
                    <h4 class="driver-edit-name">{{$name}}</h4>
                    <div class="edit-driver-address">
                        <i class="fa fa-pencil faPencilEdit faPencilEditAddress " data-toggle="modal" data-target="#address"></i>
                        <span class="driver-edit-name autocomplete address-other">{{$ads->address}}</span> <br/>
                        <span class="apt driver-edit-name address-other">{{$ads->suite_number}}</span> <br/>
                        <span class="locality driver-edit-name address-other">{{$ads->city}}</span> <br/>
                        <span class="administrative_area_level_1 driver-edit-name address-other">{{$ads->state}}</span> <br/>
                        <span class="postal_code driver-edit-name address-other">{{$ads->zip}}</span> <br/>
                        <span class="country driver-edit-name address-other">{{$ads->country}}</span>
                    </div>
                    <div class="edit-driver-address">
                        <i class="fa fa-pencil faPencilEdit faPencilEditEmail" data-toggle="modal" data-target="#email"></i>
                        <span class="driver-edit-name email">{{$ads->email}}</span> <br/>
                    </div>
                    <div class="edit-driver-address">
                        <i class="fa fa-pencil faPencilEdit faPencilEditPhone" data-toggle="modal" data-target="#phone"></i>
                        <span class="driver-edit-name phone">{{$code}} {{$phone}}</span>
                    </div>
                    <div class="form-group edit-driver-address">
                        <i class="fa fa-pencil faPencilEdit faPencilEditCard"></i>
                        <span class="driver-edit-name card">@if($cards == "") Add Card @else Card on file: {{$cards->digits}} @endif</span> <br/>
                    </div>


            </div>
            <div class="col-md-1 col-sm-2 col-xs-1"></div>
        </div>
    </div>
    <div id="driver-email-verify">
        <div class="container-fluid">
            <div class="col-md-12 align">
                <div class="col-md-7 login-div">
                    <center>
                        <div class="loginAnchor">We sent a verification code to your email.<br> Please type this code below</div>
                    <form method="post" id="verify-submit">
                        <div class="wrapper">
                            @include('flash::message')
                            <hr>
                            <p class="message"><b>Email Verification Code</b></p>

                            {{csrf_field()}}
                            <input type="hidden" name="email" id="verify-email">
                            <input type="hidden" id="adsid" name="adsid" value="{{$ads->id}}">
                            <input type="hidden" name="email_otp" id="email1">
                                <input class="qw" type="number" id="1" onkeyup="moveOnMax(this,'2')"  onKeyPress="if(this.value.length == 1) return false;"/>
                                <input class="qw" type="number" id="2" onkeyup="moveOnMax(this,'3')"  onKeyPress="if(this.value.length == 1) return false;" onkeydown="checkKey(this,1)"/>
                                <input class="qw" type="number" id="3" onkeyup="moveOnMax(this,'4')"  onKeyPress="if(this.value.length == 1) return false;" onkeydown="checkKey(this,2)"/>
                                <input class="qw" type="number" id="4" onkeyup="moveOnMax(this,'5')" onKeyPress="if(this.value.length == 1) return false;" onkeydown="checkKey(this,3)"/>
                                <input class="qw" type="number" id="5" onkeyup="moveOnMax(this,'6')" onKeyPress="if(this.value.length == 1) return false;" onkeydown="checkKey(this,4)"/>
                                <input class="qw" type="number" id="6" onkeyup="getEmailValue()" onKeyPress="if(this.value.length == 1) return false;" onkeydown="checkKey(this,5)"/>
                            {{--<hr>--}}
                        </div>
                            <button type="button" class="btn btn-primary btn-next" onclick="vewrifyEmail()">Next</button>
                    </form>


                    <div class="message">
                        You didn't receive the OTP?
                        <br>
                        <a class="loginAnchor" onclick="resendVerification()">Click to send it again</a>
                    </div>
                    </center>

                </div>
            </div>
        </div>
    </div>
    <div id="credit_card">
        <form action="" name="someform">

            <div class="col-md-12 col-xs-12 col-sm-12 form-container">
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <h4 style="color: #4d68b0;">Credit Card Information</h4>
                    <input id="input-field" class="form-control1" type="number" name="card_no" placeholder="type your credit card number" onchange="if (this.value.length < 16 || this.value.length > 16) { errorTost('Invalid Card Number'); }" onkeypress="if(this.value.length == 16) return false;"/>
                    <div class="col-md-12 col-xs-12 col-sm-12 credit-card-month">
                        <div class="col-md-6 col-xs-12 col-sm-6 date1">
                            <select class="form-control1 date-expire" name="ccExpiryMonth" id="monthdropdown"></select>
                        </div>
                        <div class="col-md-6 col-xs-12 col-sm-6 credit-card-year">
                            <select class="form-control1 date-expire" name="ccExpiryYear" id="yeardropdown"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <input id="column-right" class="form-control1" type="text" name="zip" required maxlength="8"  placeholder="ZIP code"/>
                        <input id="column-left" class="form-control1" maxlength="4" type="number" name="cvvNumber" placeholder="CCV"/>
                    </div>
                    <div style="display:none;" class="card-wrapper"></div>
                    <button class="btn btn-primary" id="input-button" type="button">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>

<center>
    <div class="modal fade" id="address" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content address-modal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Address</h4>
            </div>
            <center>
                <div class="modal-body">
                <div class="form-group">
                    <input id="autocomplete" class="form-control1" value="{{$ads->address}}" type="text" name="address" placeholder="Your address" onFocus="geolocate()" required>
                </div>
                <div class="form-group">
                    <input class="form-control1" id="apt" value="{{$ads->suite_number}}" type="text" name="suite_number" placeholder="Your apartment number" required>
                </div>
                <div class="form-group">
                    <input class="form-control1" id="locality" type="text" value="{{$ads->city}}" name="city" placeholder="Your city" required>
                </div>
                <div class="form-group">
                    <input class="form-control1" type="text" id="administrative_area_level_1" value="{{$ads->state}}" name="state" placeholder="Your state" required>
                </div>
                <div class="form-group">
                    <input class="form-control1" type="text" id="postal_code" name="zip" value="{{$ads->zip}}" placeholder="Your ZIP code" required>
                </div>
                <div class="form-group">
                    <select name="country" class="form-control1" id="country" required>
                        <option value="" selected disabled>Select a Country</option>
                        @foreach($countries as $key => $country)
                            <option value="{{$country}}" <?php if ($country == $ads->country) { echo "selected";} ?>>{{$country}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="button" id="addressSave" onclick="saveAddress()">Save</button>
                </div>
            </div>
            </center>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
            </div>
        </div>

    </div>
</div>

    <div class="modal fade" id="email" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content email-modal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Email</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="email" name="email" class="form-control1" value="{{$ads->email}}" id="editEmail">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" onclick="saveEmail()">Save</button>
                </div>
            </div>
            {{--<div class="modal-footer">--}}
            {{--</div>--}}
        </div>

    </div>
</div>

    <div class="modal fade" id="phone" role="dialog">
        <div class="modal-dialog modal-phone-number">

        <!-- Modal content-->
        <div class="modal-content modal-phone-number-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Phone</h4>
            </div>
            <div class="modal-body">
                <center>
                    <div class="input-group mb-4 form-group">
                        <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">
                            <select class="form-control1 Code"  id="country1" onchange="myFunc()">
                            <option value="" selected disabled>Select a Country</option>
                                @foreach($array as $country)
                                    <option value="{{$country->code}}" <?php if ($code == $country->code) { echo "selected"; } ?>>{{$country->name}}({{$country->code}})</option>
                                @endforeach
                        </select>
                        </span>
                        </div>
                        <input type="hidden" name="code" value="{{$code}}" id="code">
                        <input type="text" class="form-control form-control1 country" value="{{$ads->phone}}" placeholder="Your phone" name="phone" aria-describedby="basic-addon2" id="phoneNumber">
                    </div>
                </center>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary" onclick="savePhone()">Next</button>
            </div>
            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
            </div>
        </div>

    </div>

</div>
</center>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="{{asset('public/js/swipe.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>


<script>
    var placeSearch, autocomplete;

    var componentForm = {
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {

        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('autocomplete'), {types: ['geocode']});


        autocomplete.setFields(['address_component']);


        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }


        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }


    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle(
                    {center: geolocation, radius: position.coords.accuracy});
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB56Xh1A7HQDPQg_7HxrPTcSNnlpqYavc0&libraries=places&callback=initAutocomplete"
        async defer>
</script>

<script type="text/javascript">

    /***********************************************
     * Drop Down Date select script- by JavaScriptKit.com
     * This notice MUST stay intact for use
     * Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and more
     ***********************************************/

    var monthtext = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec','01','02','03','04','05','06','07','08','09','10','11','12'];

    function populatedropdown(monthfield, yearfield) {
        var today = new Date()
        var monthfield = document.getElementById(monthfield)
        var yearfield = document.getElementById(yearfield)
        for (var i = 0; i < 31; i++)


            for (var m = 0; m < 12; m++)
                monthfield.options[m] = new Option(monthtext[m], monthtext[m + 12])
        monthfield.options[today.getMonth()] = new Option(monthtext[today.getMonth()], monthtext[today.getMonth() + 12], true, true) //select today's month
        var thisyear = today.getFullYear()
        for (var y = 0; y < 50; y++) {
            yearfield.options[y] = new Option(thisyear, thisyear)
            thisyear += 1
        }
        yearfield.options[0] = new Option(today.getFullYear(), today.getFullYear(), true, true) //select today's year
    }
    $('.faPencilEditCard').click(function () {
        $('.loader').show();
        $('#driver-profile-details').hide();
        $('.loader').hide();
        $('#credit_card').show();
    });
    function errorTost(message) {
        $.toast({
            heading: 'Error',
            text: message,
            icon: 'error',
            hideAfter: 5000,
            showHideTransition: 'slide',
            loader: false
        });
    }
    $('#input-button').click(function () {
       var card = $('#input-field').val();
       var month = $('#monthdropdown').val();
       var year = $('#yeardropdown').val();
       var zip = $('#column-right').val();
       var cvv = $('#column-left').val();
       if(card == '' || card.length < 16) {
           $.toast({
               heading: 'Error',
               text: "Please enter the valid Card Number",
               icon: 'error',
               hideAfter: 5000,
               showHideTransition: 'slide',
               loader: false
           });
           $('#input-field').addClass("error");
           return false;
       }
       else {
           $('#input-field').removeClass("error");
       }
       if(month == '') {
           $.toast({
               heading: 'Error',
               text: "Please enter the valid Expiry Month",
               icon: 'error',
               hideAfter: 5000,
               showHideTransition: 'slide',
               loader: false
           });
           $('#monthdropdown').addClass("error");
           return false;
       }
       else {
           $('#monthdropdown').removeClass("error");
       }
       if(year == '') {
           $.toast({
               heading: 'Error',
               text: "Please enter the valid Expiry Year",
               icon: 'error',
               hideAfter: 5000,
               showHideTransition: 'slide',
               loader: false
           });
           $('#yeardropdown').addClass("error");
           return false;
       }
       else {
           $('#yeardropdown').removeClass("error");
       }
       if(cvv == '') {
           $.toast({
               heading: 'Error',
               text: "Please enter the valid CVV",
               icon: 'error',
               hideAfter: 5000,
               showHideTransition: 'slide',
               loader: false
           });
           $('#column-left').addClass("error");
           return false;
       }
       else {
           $('#column-left').removeClass("error");
       }
       if(zip == '' || zip.length < 5) {
           $.toast({
               heading: 'Error',
               text: "Please enter the valid Zip",
               icon: 'error',
               hideAfter: 5000,
               showHideTransition: 'slide',
               loader: false
           });
           $('#column-right').addClass("error");
           return false;
       }
       else {
           $('#column-right').removeClass("error");
       }
       $('.loader').show();
       $.ajax({
                url: "{{url('advertisement/saveCard')}}",
                type: "post",
                {{--data: {card_no:card, ccExpiryMonth:month, ccExpiryYear: year, cvvNumber:cvv, zip:zip, _token:'{{csrf_token()}}'},--}}
                data: {card_no:card, ccExpiryMonth:month, ccExpiryYear: year, cvvNumber:cvv, _token:'{{csrf_token()}}'},
                success:function (result) {
                    console.log(result);
                    $('.loader').hide();
                    if (result['code'] == 1)
                    {
                       $('.card').text("Card on file: "+result['card']);
                        $('#credit_card').hide();
                        $('#driver-profile-details').show();
                        $.toast({
                            heading: 'Success',
                            text: "Card is saved.",
                            icon: 'success',
                            hideAfter: 5000,
                            showHideTransition: 'slide',
                            loader: false
                        });
                    }
                    else if (result['code'] == 2)
                    {
                        $('#credit_card').hide();
                        $('#driver-profile-details').show();
                        $.toast({
                            heading: '',
                            text: result['message'],
                            icon: 'info',
                            hideAfter: 5000,
                            showHideTransition: 'slide',
                            loader: false
                        });
                    }
                    else
                    {
                        $.toast({
                            heading: 'Failed',
                            text: result['message'],
                            icon: 'error',
                            hideAfter: 5000,
                            showHideTransition: 'slide',
                            loader: false
                        });
                    }
                },
                error:function(error){
                    $('.loader').hide();
                    $.toast({
                        heading: 'Error',
                        text: "Could not save the Card.",
                        icon: 'error',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    });
                }
       });
    });
</script>
<script type="text/javascript">

    //populatedropdown(id_of_day_select, id_of_month_select, id_of_year_select)
    window.onload = function () {
        populatedropdown("monthdropdown", "yeardropdown")
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });
        $('#dismiss, .overlay').on('click', function () {
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
            $("body").css("overflow","auto");
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').addClass('active');
            $('.overlay').addClass('active');
            $("body").css("overflow","hidden");
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
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

    $(document).ready(function() {
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
        // Gets the span width of the filled-ratings span
        // this will be the same for each rating
        var star_rating_width = $('.fill-ratings span').width();
        // Sets the container of the ratings to span width
        // thus the percentages in mobile will never be wrong
        $('.star-ratings').width(star_rating_width);
    });
    function triggerUpload() {
        $('#license').trigger('click');
    }
    function saveImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
                $('#main-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        var form = $('#editProfile')[0];
//        var image = $("#license")[0].files[0];
        var data = new FormData(form);
        data.append("_token", "{{csrf_token()}}");
//        var driverid = $('#driverid').val();
        $.ajax({
            type: "POST",
            url: "{{url('advertisement/editProfile')}}",
            data: data,
            processData: false,
            contentType: false,
            success: function(result) {
                $.toast({
                    heading: 'Success',
                    text: 'Profile image Changed.',
                    icon: 'success',
                    hideAfter: 5000,
                    showHideTransition: 'slide',
                    loader: false
                })
            }

        });
    }
    function vewrifyEmail() {
        $('.loader').show();
        if ($('#email1').val() == '')
        {
            $.toast({
                heading: 'Failed',
                text: 'Verification code is empty.',
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            $('.loader').hide();
            return false;
        }
        $.ajax({
            type: "POST",
            url: "{{url('advertisement/verifyChangeEmail')}}",
            data: {_token:'{{csrf_token()}}',adId:$('#adsid').val(),email:$('#verify-email').val(),otp:$('#email1').val()},
            success: function(result) {
                $('.loader').hide();
                if (result ==1)
                {
                    $('.email').text($('#verify-email').val());
                    $('#driver-profile-details').show();
                    $('#driver-email-verify').hide();
                    $('.qw').val('');
                    $('#email1').val('');
                    $.toast({
                        heading: 'Success',
                        text: 'Email is verified.',
                        icon: 'success',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    })
                }
                else
                {
                    $('.qw').val('');
                    $('#email1').val('');
                    $.toast({
                        heading: 'Failed',
                        text: 'Email verification failed.',
                        icon: 'error',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    })
                }
            }

        });
    }
    function saveAddress() {
        var address = $('#autocomplete').val();
        var apt = $('#apt').val();
        var city = $('#locality').val();
        var state = $('#administrative_area_level_1').val();
        var zip = $('#postal_code').val();
        var country = $('#country').val();
        var driverid = $('#driverid').val();


        $.ajax({
            type: "POST",
            url: "{{url('advertisement/editProfile')}}",
            data: {address: address, city: city, state:state, country:country, zip:zip, suite_number:apt, type:1, adId:driverid, _token: "{{ csrf_token() }}"},
            success: function(result) {
                if (result == 1)
                {
                    if (address != '')
                    {
                        $('.autocomplete').text(address);
                    }
                    if (apt != '')
                    {
                        $('.apt').text(apt);
                    }
                    $('.locality').text(city);
                    $('.administrative_area_level_1').text(state);
                    $('.postal_code').text(zip);
                    $('.country').text(country);
                    $('#address').modal('hide');
                    $.toast({
                        heading: 'Success',
                        text: 'Address is updated.',
                        icon: 'success',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    })
                }
                else
                {
                    $('#address').modal('hide');
                    $.toast({
                        heading: 'Failed',
                        text: 'Could not Update the Address.',
                        icon: 'error',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    });
                }
            }

        });
    }
    function saveEmail() {
        var email = $('#editEmail').val();
        var oldEmail = $('.email').text();
        if(email == oldEmail)
        {
            $('#email').modal('hide');
            return false;
        }
        $('.loader').show();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email))
        {
            $('#editEmail').addClass("error");
            $.toast({
                heading: 'Failed',
                text: 'Email is not valid.',
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            return false;
        }
        var driverid = $('#driverid').val();
        $('#editEmail').removeClass("error");
        $.ajax({
            type: "POST",
            url: "{{url('advertisement/editProfile')}}",
            data: {email: email, adId:driverid, _token: "{{ csrf_token() }}",type:3},
            success: function(result) {
                if(result == 1)
                {
//                    $('.email').text(email);
//                    $('.email').css('color','#4d68b0');
                    $('#email').modal('hide');
                    $('.loader').hide();
                    $('#driver-profile-details').hide();
                    $('#driver-email-verify').show();
                    $('#verify-email').val(email);
                    $.toast({
                        heading: 'Verify',
                        text: 'You need to verify the Email.',
                        icon: 'info',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    })
                }
                else if(result == 2)
                {
                    $('.email').css('color','red');
                    $('#email').modal('hide');
                    $('#editEmail').val($('.email').text());
                    $('.loader').hide();
                    $.toast({
                        heading: 'Failed',
                        text: 'Email is already exists.',
                        icon: 'error',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    })
                }
                else
                {
                    $('#email').modal('hide');
                    $('.loader').hide();
                    $.toast({
                        heading: 'Failed',
                        text: 'We could not update your email. Please try again.',
                        icon: 'error',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    })
                }
            },
            error: function(error)
            {
                $('#email').modal('hide');
                $('.loader').hide();
                $.toast({
                    heading: 'Failed',
                    text: 'We could not update your email. Please try again.',
                    icon: 'error',
                    hideAfter: 5000,
                    showHideTransition: 'slide',
                    loader: false
                })
            }

        });
    }
    function myFunc() {
        var code = $('#country1').val();
//        console.log(code);
        $('#code').val(code);
    }
    $(document).ready(function() {
        $('#country1 option')[0].value=$('#country1 option:selected').val();
        $('#country1 option')[0].innerHTML=$('#country1 option:selected').val();
        $("#country1").val($('#country1 option:selected').val());

        $('#country1').change(function() {
            $('#country1 option')[0].value=$('#country1 option:selected').val();
            $('#country1 option')[0].innerHTML=$('#country1 option:selected').val();
            $("#country1").val($('#country1 option:selected').val());
        });
    });
    function savePhone() {
        var code = $('#code').val();
        var phone = $('#phoneNumber').val();
            var cleaned = ('' + phone).replace(/\D/g, '')
            var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/)
            if (match) {
                var formattedNum = '(' + match[1] + ') ' + match[2] + '-' + match[3]
            }
        var phoneNumber = code+' '+formattedNum;
        var driverid = $('#driverid').val();
        $.ajax({
            type: "POST",
            url: "{{url('advertisement/editProfile')}}",
            data: {phone: phone, code: code, type:4, adId:driverid, _token: "{{ csrf_token() }}"},
            success: function(result) {
                if (result == 1)
                {
                    $('.phone').text(phoneNumber);
                    $('#phone').modal('hide');
                    $.toast({
                        heading: 'Success',
                        text: 'Phone number is Updated.',
                        icon: 'success',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    });
                }
                else
                {
                    $('#phone').modal('hide');
                    $.toast({
                        heading: 'Failed',
                        text: 'Could not update Phone Number.',
                        icon: 'error',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    })
                }
            },
            error: function (error) {
                $('#phone').modal('hide');
                $.toast({
                    heading: 'Failed',
                    text: 'Could not update Phone Number.',
                    icon: 'error',
                    hideAfter: 5000,
                    showHideTransition: 'slide',
                    loader: false
                })
            }

        });
    }
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
    function resendVerification() {
        $('.loader').show();
        var email = $('#verify-email').val();
        $.ajax({
           url: "{{url('advertisement/resentEmailOtp')}}",
           type: "post",
           data: {email:email, _token:"{{csrf_token()}}"},
           success: function (result) {
               $('.loader').hide();
               $('.qw').val("");
               $.toast({
                   heading: 'Success',
                   text: 'Verification code resent.',
                   icon: 'success',
                   hideAfter: 5000,
                   showHideTransition: 'slide',
                   loader: false
               })
           },
           error: function (error) {
               $('.loader').hide();
               $.toast({
                   heading: 'Failed',
                   text: 'Could not resent the verification.',
                   icon: 'error',
                   hideAfter: 5000,
                   showHideTransition: 'slide',
                   loader: false
               })
           }
        });
    }
    function checkKey(field,nextFieldID) {
        if ((event.keyCode == 8 || event.keyCode == 46) && $(field).val() == '')
        {
//            $(field).val('');
            document.getElementById(nextFieldID).focus();
        }
    }
</script>