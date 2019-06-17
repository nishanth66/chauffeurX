<div class="overlay" id="overlay"></div>
@include('drivers.FrontEnd.header')
@include('advertisements.FrontEnd.sideBar')
<style>
    .switch
    {
        position: relative !important;
        top: 0 !important;
        right: 0 !important;
    }
    .navbar
    {
        min-height: 0 !important;
    }
    .slider:before
    {
        left: 5px !important;
    }
    #adCreateErrorAlert
    {
        display: none;
    }
    .error
    {
        border-color: red !important;
    }
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }


</style>

<div class="col-md-12 col-xs-12 col-sm-12">
    <div class="col-md-2 col-sm-2 col-xs-1"></div>
    <div class="col-md-8 col-sm-8 col-xs-10">
        <div class="alert alert-danger login-div" role="alert" id="adCreateErrorAlert"></div>
        <h3 class="create-new-ad">Edit a ad</h3>
        {!! Form::model($advrt, ['route' => ['advertisements.update', $advrt->id], 'method' => 'patch','files' => true]) !!}
            {{csrf_field()}}
            <div class="form-group required">
                <label>Select your category</label>
                <select class="form-control create-ad-form" name="category" id="category">
                    <option value="" selected disabled>Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" @if($advrt->category == $category->id) selected @endif >{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Upload your image</label><br>
                <input id="file-upload" type="file" name="image" accept="image/*" style="display:none;" onchange="readURL(this);">
                @if(isset($advrt->image) && empty($advrt->image) || $advrt->image == '' || $advrt->image == null)
                    <img id="image" src="{{asset('public/image/addimage.jpg')}}" class="ad-create-image">
                @else
                    <img id="image" src="{{asset('public/avatars').'/'.$advrt->image}}" class="ad-create-image">
                @endif
            </div>
            <div class="form-group required">
                <label>Type your call to action</label>
                <textarea rows="2" cols="20" name="description" class="form-control create-ad-form create-ad-textarea" placeholder="Get our new Power Honey juice 50%off with this code: ChaufferX" id="description">{{$advrt->description}}</textarea>
            </div>
            <div class="form-group required">
                <label>Link</label>
                <input id="link" class="form-control create-ad-form" type="url" value="{{$advrt->link}}" name="link" placeholder="Enter the Bussiness Link">
            </div>
            <div class="form-group required">
                <label>Address</label>
                <input id="autocomplete" class="form-control create-ad-form" value="{{$advrt->address}}" type="text" name="address" placeholder="Enter the advertisement address" onFocus="geolocate()">
            </div>
            <div class="form-group required">
                <label>Setup your maximum daily budget</label>
                <input type="text" class="form-control create-ad-form max-daily-budget" placeholder="Max Daily Budget" id="max" name="max_day_budget" value="{{$advrt->max_day_budget}}">
                <p><i>The cost per impression is ${{$viewCost}}</i></p>
            </div>
            <div class="form-group">
                <label>Display your add when customers filter your category</label>
                <br>
                <label class="switch" for="checkbox">
                    <input type="checkbox" id="checkbox" @if($advrt->filter_category == 1) checked @endif onchange="checkboxValue()">
                    <div class="slider round"></div>
                </label>
                <input type="hidden" name="filter_category" id="filter_category" value="{{$advrt->filter_category}}">
                <p><i>The cost per impression ina a filtered category is ${{$catCost}}</i></p>
            </div>

            <button type="submit" class="btn btn-primary btn-create-ad" onclick="validateForm(event)" id="launchBtn">Save</button>

        {!! Form::close() !!}
    </div>
    <div class="col-md-2 col-sm-2 col-xs-1"></div>
</div>

</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="{{asset('public/js/swipe.js')}}"></script>
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
                heading: 'Faield',
                text: $('.alert-danger').text(),
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            })

        }
    });
    $('#image').click(function () {
        $('#file-upload').trigger('click');
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
//                $('#main-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function checkboxValue()
    {
        if($('#checkbox').is(':checked'))
            $('#filter_category').val(1);
        else
            $('#filter_category').val(0);
    }
    function validateForm(e) {
        var category = $('#category').val();
        var description = $('#description').val();
        var max = $('#max').val();
        var link = $('#link').val();
        var address = $('#autocomplete').val();
        if (category == '' || category == null)
        {
            e.preventDefault();
            $('#launchBtn').prop('type','button');
            $('input').removeClass('error');
            $('#category').addClass("error");
            $('#description').removeClass("error");
            $.toast({
                heading: 'Faield',
                text: "Category is required",
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return false;
        }
        else if(description == '' || description == null)
        {
            e.preventDefault();
            $('#category').removeClass("error");
            $('input').removeClass('error');
            $('#description').addClass("error");
            $.toast({
                heading: 'Faield',
                text: "Your call to action is required",
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return false;
        }
        else if(address == '' || address == null)
        {
            e.preventDefault();
            $('#category').removeClass("error");
            $('input').removeClass('error');
            $('#description').addClass("error");
            $.toast({
                heading: 'Faield',
                text: "Address is required",
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return false;
        }
        else if(max == '' || max == null)
        {
            e.preventDefault();
            $('#category').removeClass("error");
            $('input').removeClass('error');
            $('#max').addClass("error");
            $.toast({
                heading: 'Faield',
                text: "Maximum Daily Budget is required",
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return false;
        }
        else if(link == '' || link == null)
        {
            e.preventDefault();
            $('#category').removeClass("error");
            $('input').removeClass('error');
            $('#link').addClass("error");
            $.toast({
                heading: 'Faield',
                text: "Bussiness Link is required",
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return false;
        }
        var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
        if (!re.test(link)) {
            e.preventDefault();
            $('#category').removeClass("error");
            $('input').removeClass('error');
            $('#link').addClass("error");
            $.toast({
                heading: 'Faield',
                text: "Please enter the valid link",
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            return false;
        }
        else
        {
            $('#category').removeClass("error");
            $('#description').removeClass("error");
            $('#launchBtn').prop('type','submit');
        }
    }
</script>

<script>
    var placeSearch, autocomplete;

    var componentForm = {

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