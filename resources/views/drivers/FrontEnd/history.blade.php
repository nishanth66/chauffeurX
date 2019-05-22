<div class="overlay" id="overlay"></div>
@include('drivers.FrontEnd.header')
@include('drivers.FrontEnd.sideBar')
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />

<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 500px;
        width: 450px;
        display: none;
        float: right !important;
    }
    .pagination>li>a, .pagination>li>span {
        position: relative !important;
        float: left !important;
        padding: 6px 12px !important;
        margin-left: -1px !important;
        line-height: 1.42857143 !important;
        color: #4d68b0 !important;
        text-decoration: none !important;
        background-color: #fff !important;
        border: 1px solid #ddd !important;
    }
    /* Optional: Makes the sample page fill the window. */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .navbar
    {
        min-height: 0;
        margin-bottom: 0 !important;
        border: none !important;
    }
    .gm-svpc, .gm-fullscreen-control, .gm-style-mtc, .gmnoprint
    {
        display: none !important;
    }
    .gmnoprint
    {
        display: none !important;
    }
    .in
    {
        display: flex !important;
    }
    .modal-dialog
    {
        margin: auto;
        /*width: 100%;*/
    }
    .modal-footer
    {
        border-top: none;
    }
    .modal-header
    {
        border-bottom: none;
    }
    @media (max-width: 768px)
    {
        .modal-dialog
        {
            width: 100%;
        }
    }
</style>
<div class="overlay"></div>
    <input type="hidden" id="start" value="12.9716,77.5946">
    <input type="hidden" id="end" value="12.2958,76.6394">
<input type="hidden" id="driverid" value="{{$driver->id}}">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs 12 login-div">

            <center>
                <?php
                    $to = explode(' ',Session::get('toDate'));
                    $from = explode(' ',Session::get('fromDate'));
                ?>
                <h3 class="history-between-text" id="between">Between {{date('m/d/Y',strtotime($from[0]))}} and {{date('m/d/Y',strtotime($to[0]))}} <i class="fa fa-pencil" onclick="assignDate()" data-toggle="modal" data-target="#betweenValues"></i></h3>

                <input type="hidden" value="{{date('m/d/Y',strtotime($from[0]))}}" id="betweenStart">
                <input type="hidden" value="{{date('m/d/Y',strtotime($to[0]))}}" id="betweenEnd">
            </center>

    </div>
</div>
    <div class="col-md-12 col-sm-12 scrollable ride-history login-div">
        <div class="col-md-7 col-sm-7 col-xs-12">
            <div class="row" id="newValue">
                <?php
                    $i=1;
                ?>
                @foreach($rides as $ride)
                    <?php
                        $src = explode(',',$ride->source);
                        $dest  =explode(',',$ride->destination);
                        $StartAddress = getAddress($src[0],$src[1]);
                        $EndAddress = getAddress($dest[0],$dest[1]);
                        $mins = (strtotime($ride->trip_end_time) - strtotime($ride->trip_start_time))/60;
                        if ($mins > 60)
                        {
                            $mins = number_format($mins/60,'2') .' hr';
                        }
                        else
                        {
                            $mins = number_format($mins).' min';
                        }
                    ?>
                {{--<div class="col-md-1 col-sm-1 col-xs-1"></div>--}}
                <div class="row ride-complete-details" id="{{$ride->id}}">
                    <input type="hidden" id="source{{$ride->id}}" value="{{$ride->source}}">
                    <input type="hidden" id="dest{{$ride->id}}" value="{{$ride->destination}}">
                    <div class="col-md-2 col-sm-3 col-xs-4 ride-history-date">
                        {{date('m/d/Y',strtotime($ride->trip_end_time))}} <br/> {{date('g:i A',strtotime($ride->trip_start_time))}}
                    </div>
                    <div class="col-md-9 col-sm-8 col-xs-7 ride-details-edit form-group">
                        <b>Pickup Address:</b>
                        {{$StartAddress}}
                        <br/>
                        <b>Drop Off Location:</b>
                        {{$EndAddress}}
                        <br/>
                        <b>Duration:</b>
                        {{$mins}}
                        <br/>
                        <b>Distance:</b>
                        {{--@if($ride->distance > 1)--}}
                            {{number_format($ride->distance/1.609,'2')}} Miles
                        {{--@else--}}
{{--                            {{$ride->distance*1000}} Metres--}}
                        {{--@endif--}}
                        <br/>
                        <b>Credit Card:</b>
                        &dollar;{{number_format($ride->price)}}
                        <br/>
                    </div>
                </div>
                <?php
                $i++;
                ?>
                @endforeach
            </div>
        </div>
        <div class="col-md-5 col-sm-5 desktop">
            <div id="map"></div>
        </div>
    </div>
<div class="row">
    <center>
        <div>
            {{$rides->render()}}
        </div>
    </center>
</div>
{{--<button type="button" class="btn btn-default" onclick="changeValue()">Change Value</button>--}}

<?php
function getAddress($lat,$lon)
{
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lon&key=AIzaSyB56Xh1A7HQDPQg_7HxrPTcSNnlpqYavc0";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
        return $response_a['results'][0]['formatted_address'];
}
?>
<div class="modal fade" id="betweenValues" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3 col-xs-3"></div>
                    <div class="form-group date col-sm-8 col-xs-8" data-date-format="mm-dd-yyyy">
                        <label>From Date</label>
                        <input class="form-control1 datepicker" type="text" id="date1" readonly />
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-3"></div>
                    <div class="form-group date col-sm-8 col-xs-8" data-date-format="mm-dd-yyyy">
                        <label>To Date</label>
                        <input class="form-control1 datepicker" type="text" id="date2" readonly />
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="row">
                    <center>
                        <button type="button" class="btn btn-primary" onclick="assignNewDate()">Save</button>
                    </center>
                </div>
            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
            </div>
        </div>

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="{{asset('public/js/swipe.js')}}"></script>
<script>
    $(function () {
        var $h3s = $('.ride-complete-details').click(function () {
            var id = $(this).attr('id');
            var start = $('#source'+id).val();
            var end = $('#dest'+id).val();
            if($(this).hasClass('ride-active'))
            {
                $('#map').hide();
                $(this).removeClass('ride-active');
            }
            else
            {
                $h3s.removeClass('ride-active');
                $(this).addClass('ride-active');
                $('#start').val(start);
                $('#end').val(end);
                $('#map').show();
                $('#end').val(end).change();
            }
        });
    });
    function assignDate() {
        $('#date1').val($('#betweenStart').val());
        $('#date2').val($('#betweenEnd').val());
    }
    function changeValue(src,dest) {

        if($('.ride-complete-details').hasClass('ride-active'))
        {
            var start = src;
            var end = dest;
            $('#start').val(start);
            $('#end').val(end);
            $('#map').show();
            $('#end').val(end).change();
        }
        else
        {
            $('#map').hide();
        }

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
            $("body").scrollTop(0);
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
    function assignNewDate()
    {
        var from = $('#date1').val();
        var to = $('#date2').val();
        var driverid = $('#driverid').val();
        $('#betweenStart').val(from);
        $('#betweenEnd').val(to);
        from = from.replace(new RegExp('/', 'g'),'-');
        to = to.replace(new RegExp('/', 'g'),'-');
        $.ajax({
            url: "{{url('driver/fromToDate')}}"+"/"+from+"/"+to+"/"+driverid,
            success: function(result)
            {
                $('#betweenValues').modal('toggle');
                window.location.reload();
            }
        });
    }
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script>
    $(function () {
        $(".datepicker").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('update', new Date());
    });
</script>