@include('drivers.FrontEnd.topbar')
<style>
    .form-control{
        color: #4D68B0 !important;
    }
</style>
<div class="container-fluid">
    <div class="col-md-12 align">
        <div class="col-md-4">
            <p class="textclr login-div"> Hi {{$name}}, <br> Where is your Bussiness Located?</p>
            <br>
            <center>
                <div class="col-md-12">
                    @include('flash::message')
                    <form method="post" action="{{url('advertisement/address')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input id="autocomplete" class="form-control1" value="{{$ads->address}}" type="text" name="address" placeholder="Your address" onFocus="geolocate()" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control1" value="{{$ads->suite_number}}" type="text" name="suite_number" placeholder="Suit Number" required>
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
                            <button type="submit" class="btn btn-primary next-btn">Next</button>
                        </div>
                    </form>
                </div>
            </center>
        </div>
    </div>
</div>

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