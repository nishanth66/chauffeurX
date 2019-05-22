<div class="overlay" id="overlay"></div>
@include('drivers.FrontEnd.header')
@include('drivers.FrontEnd.sideBar')
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

</style>
    <div class="driver-profile-details">
        @include('flash::message')
        <div class="row">
            <div class="col-md-3 col-sm-2 col-xs-1"></div>
            <div class="col-md-8 col-sm-8 col-xs-10">
                <form method="post" action="{{url('driver/editProfile')}}" enctype="multipart/form-data" id="editProfile">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$driver->id}}" name="driverid" id="driverid">
                    <input type="hidden" value="2" name="type">
                    <div style="position: relative;">
                        @if(isset($driver->image) && $driver->image != '' || !empty($driver->image))
                            <img id="image" src="{{asset('public/avatars').'/'.$driver->image}}" class="img-circle driver-edit-logo">
                        @else
                            <img id="image"  src="{{asset('public/image/faCar.png')}}" class="img-circle driver-edit-logo">
                        @endif
                    </div>
                    <i class="fa fa-pencil faPencil" onclick="triggerUpload()"></i>
                    <input type="file" name="image" id="license"  style="display: none;" accept="image/*" onchange="saveImg(this);">
                </form>
                    <h4 class="driver-edit-name">{{$driver_name}}</h4>
                    <div class="edit-driver-address">
                        <i class="fa fa-pencil faPencilEdit faPencilEditAddress " data-toggle="modal" data-target="#address"></i>
                        <span class="driver-edit-name autocomplete address-other">{{$address->address}}</span> <br/>
                        <span class="apt driver-edit-name address-other">{{$address->apartment}}</span> <br/>
                        <span class="locality driver-edit-name address-other">{{$address->city}}</span> <br/>
                        <span class="administrative_area_level_1 driver-edit-name address-other">{{$address->state}}</span> <br/>
                        <span class="postal_code driver-edit-name address-other">{{$address->zip}}</span> <br/>
                        <span class="country driver-edit-name address-other">{{$address->country}}</span>
                    </div>
                    <div class="edit-driver-address">
                        <i class="fa fa-pencil faPencilEdit faPencilEditEmail" data-toggle="modal" data-target="#email"></i>
                        <span class="driver-edit-name email">{{$driver->email}}</span> <br/>
                    </div>
                    <div class="form-group edit-driver-address">
                        <i class="fa fa-pencil faPencilEdit faPencilEditPhone" data-toggle="modal" data-target="#phone"></i>
                        <span class="driver-edit-name phone">{{$code}} {{$phone}}</span> <br/>
                    </div>


            </div>
            <div class="col-md-1 col-sm-2 col-xs-1"></div>
        </div>
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
                    <input id="autocomplete" class="form-control1" value="{{$address->address}}" type="text" name="address" placeholder="Your address" onFocus="geolocate()" required>
                </div>
                <div class="form-group">
                    <input class="form-control1" id="apt" value="{{$address->apartment}}" type="text" name="apartment" placeholder="Your apartment number" required>
                </div>
                <div class="form-group">
                    <input class="form-control1" id="locality" type="text" value="{{$address->city}}" name="city" placeholder="Your city" required>
                </div>
                <div class="form-group">
                    <input class="form-control1" type="text" id="administrative_area_level_1" value="{{$address->state}}" name="state" placeholder="Your state" required>
                </div>
                <div class="form-group">
                    <input class="form-control1" type="text" id="postal_code" name="zip" value="{{$address->zip}}" placeholder="Your ZIP code" required>
                </div>
                <div class="form-group">
                    <select name="country" class="form-control1" id="country" required>
                        <option value="" selected disabled>Select a Country</option>
                        @foreach($countries as $key => $country)
                            <option value="{{$country}}" <?php if ($country == $address->country) { echo "selected";} ?>>{{$country}}</option>
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
                    <input type="text" name="email" class="form-control1" value="{{$driver->email}}" id="editEmail">
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
                        <input type="text" class="form-control form-control1 country" value="{{$driver->phone}}" placeholder="Your phone" name="phone" aria-describedby="basic-addon2" id="phoneNumber">
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

//    $(document).ready(function() {
//        $('select option')[0].value=$('select option:selected').val();
//        $('select option')[0].innerHTML=$('select option:selected').val();
//        $("select").val($('select option:selected').val());
//
//        $('select').change(function() {
//            $('select option')[0].value=$('select option:selected').val();
//            $('select option')[0].innerHTML=$('select option:selected').val();
//            $("select").val($('select option:selected').val());
//        });
//    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB56Xh1A7HQDPQg_7HxrPTcSNnlpqYavc0&libraries=places&callback=initAutocomplete"
        async defer>
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
    });

    $(document).ready(function() {
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
            url: "{{url('driver/editProfile')}}",
            data: data,
            processData: false,
            contentType: false,
            success: function(result) {
            }

        });
    }
    function saveAddress() {
        var address = $('#autocomplete').val();
        if (address != '')
        {
            $('.autocomplete').text(address);
        }
        var apt = $('#apt').val();
        if (apt != '')
        {
            $('.apt').text(apt);
        }
        var city = $('#locality').val();
        var state = $('#administrative_area_level_1').val();
        var zip = $('#postal_code').val();
        var country = $('#country').val();
        var driverid = $('#driverid').val();

        $('.locality').text(city);
        $('.administrative_area_level_1').text(state);
        $('.postal_code').text(zip);
        $('.country').text(country);
        $('#address').modal('hide');

        $.ajax({
            type: "POST",
            url: "{{url('driver/editProfile')}}",
            data: {address: address, city: city, state:state, country:country, zip:zip, apartment:apt, type:1, driverid:driverid, _token: "{{ csrf_token() }}"},
            success: function(result) {
                console.log(result);
            }

        });
    }
    function saveEmail() {
        var email = $('#editEmail').val();
        $('.email').text(email);
        $('#email').modal('hide');
        var driverid = $('#driverid').val();

        $.ajax({
            type: "POST",
            url: "{{url('driver/editProfile')}}",
            data: {email: email, driverid:driverid, _token: "{{ csrf_token() }}",type:3},
            success: function(result) {
                console.log(result);
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
        $('.phone').text(phoneNumber);
        $('#phone').modal('hide');
        var driverid = $('#driverid').val();
        $.ajax({
            type: "POST",
            url: "{{url('driver/editProfile')}}",
            data: {phone: phone, code: code, type:4, driverid:driverid, _token: "{{ csrf_token() }}"},
            success: function(result) {
                console.log(result);
            }

        });
    }
</script>