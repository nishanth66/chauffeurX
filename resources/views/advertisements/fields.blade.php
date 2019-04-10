
<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <input type="file" name="image" class="form-control" onclick="readURL(this)">
{{--    {!! Form::file('image', null, ['class' => 'form-control']) !!}--}}
    <div id="image">
        @if(isset($advertisement) && $advertisement != '')
            @if(isset($advertisement->image))
                <img src="{{asset('public/avatars').'/'.$advertisement->image}}" class="show-image">
            @endif
        @endif
    </div>
</div>

<!-- Place Field -->
<div class="form-group col-sm-12">
    {!! Form::label('address', 'Address:') !!}
    <input id="autocomplete" name="address" class="form-control" value="@if(isset($advertisement)) {{$advertisement->address}} @endif" placeholder="Enter your address" onFocus="geolocate()" type="text"/>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('advertisements.index') !!}" class="btn btn-default">Cancel</a>
</div>


<script>
    function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('autocomplete'), {types: ['geocode']});
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


<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var html = '<br/><img class="show-image" src="' + e.target.result + '">';
                $('#image')
                    .html(html);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
