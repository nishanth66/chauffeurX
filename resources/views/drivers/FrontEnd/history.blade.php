@include('drivers.FrontEnd.header')
@include('drivers.FrontEnd.sideBar')
<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 300px;
        width: 450px;
        display: none;
        float: right !important;
    }
    /* Optional: Makes the sample page fill the window. */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .gm-svpc, .gm-fullscreen-control, .gm-style-mtc, .gmnoprint
    {
        display: none !important;
    }
    .gmnoprint
    {
        display: none !important;
    }
</style>
    <input type="hidden" id="start" value="12.9716,77.5946">
    <input type="hidden" id="end" value="12.2958,76.6394">
    <div class="col-md-12 col-sm-12 scrollable ride-history">
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="row">
                <div class="col-md-2 col-sm-3 col-xs-12 ride-history-date">
                    04/01/2019 <br/> 03:45pm
                </div>
                <div class="col-md-10 col-sm-9 col-xs-12 ride-details-edit">
                    Pickup Address: 301 E Pikes Peak Avenue Colorodo Spring <br/>
                    Drop Off Location: 1426 E Platte Avenue Colorodo Spring <br/>
                    Duration: 6 min <br/>
                    Credit Card: &dollar;9.45 <br/>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 desktop">
            <div id="map"></div>
        </div>
    </div>
<button type="button" class="btn btn-default" onclick="changeValue()">Change Value</button>

{{--<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
<!-- Popper.JS -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>--}}
<!-- Bootstrap JS -->
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    function changeValue() {
        var start = '12.9719,77.5127';
        var end = '12.9767,77.5713';
        $('#start').val(start);
        $('#map').show();
        $('#end').val(end).change();
    }
    $('#end').change(function () {
        initMap();
    });
    function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: {lat: 12.9716, lng: 77.5946}
        });
        directionsDisplay.setMap(map);
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    }
    function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        directionsService.route({
            origin: document.getElementById('start').value,
            destination: document.getElementById('end').value,
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB56Xh1A7HQDPQg_7HxrPTcSNnlpqYavc0&callback=initMap">
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            if ($('#sidebar').hasClass('active'))
            {
                $('.driver-header-name').hide();
            }
            else
            {
                $('.driver-header-name').show();
            }
        });
    });
</script>