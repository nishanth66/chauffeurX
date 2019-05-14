@include('drivers.FrontEnd.header')
@include('drivers.FrontEnd.sideBar')
<div class="row">
    <div class="col-md-2 col-sm-2"></div>
    <div class="col-sm-8 col-md-8 col-xs-12 driverDaysToggle">
        <div class="col-md-3 col-sm-3 col-xs-12 type-none-driver-home" onclick="changeData('1')">1 DAY</div>
        <div class="col-md-3 col-sm-3 col-xs-12 type-none-driver-home present presentClick" onclick="changeData('2')">7 DAYS</div>
        <div class="col-md-3 col-sm-3 col-xs-12 type-none-driver-home" onclick="changeData('3')">30 DAYS</div>
        <div class="col-md-3 col-sm-3 col-xs-12 type-none-driver-home" onclick="changeData('4')">This Month</div>
    </div>
    <div class="col-md-2 col-sm-2"></div>

</div>
<br/> <br/>
<div class="driver-ride-details">
    <div class="row">
        <div class="col-md-2 col-sm-2"></div>
            <div class="col-md-3 col-sm-3 col-xs-7">
                <span class="driver-text">Your Revenue </span>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-5">
                <span class="driver-value" id="revenue">&dollar;{{number_format($revenue)}}</span>
            </div>
        <div class="col-md-2 col-sm-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-2"></div>
            <div class="col-md-3 col-sm-3 col-xs-7">
                <span class="driver-text">Number of Rides </span>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-5">
                <span class="driver-value" id="rides">{{number_format($rides)}}</span>
            </div>
        <div class="col-md-2 col-sm-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-2"></div>
            <div class="col-md-3 col-sm-3 col-xs-7">
                <span class="driver-text">Distance Driven </span>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-5">
                <span class="driver-value" id="distance">{{number_format($distance,'2')}} Miles</span>
            </div>
        <div class="col-md-2 col-sm-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-2"></div>
            <div class="col-md-3 col-sm-3 col-xs-7">
                <span class="driver-text">Rating </span>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-5">
                <div class="star-ratings">
                    <div class="fill-ratings" id="rate" style="width: {{$rating}}%;">
                        <span>★★★★★</span>
                    </div>
                    <div class="empty-ratings">
                        <span>★★★★★</span>
                    </div>
                </div>
            </div>
        <div class="col-md-2 col-sm-2"></div>
    </div>
</div>
</div>
</div>


<!-- jQuery CDN - Slim version (=without AJAX) -->
{{--<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}

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

    $(document).ready(function() {
        // Gets the span width of the filled-ratings span
        // this will be the same for each rating
        var star_rating_width = $('.fill-ratings span').width();
        // Sets the container of the ratings to span width
        // thus the percentages in mobile will never be wrong
        $('.star-ratings').width(star_rating_width);
    });

    $(function () {
        var $h3s = $('.type-none-driver-home').click(function () {
            $h3s.removeClass('present');
            $h3s.removeClass('presentClick');
            $(this).addClass('present');
            $(this).addClass('presentClick');
        });
    });
    $(".type-none-driver-home").mouseover(function(){
        $(this).addClass('present');
    });
    $(".type-none-driver-home").mouseout(function(){
        if($(this).hasClass('presentClick') == 0)
        {
            $(this).removeClass('present');
        }
    });
    function changeData(val) {
        $.ajax({
            url: "{{url('changeData')}}"+"/"+val,
            success: function(result)
            {
                $('#revenue').text(result['revenue']);
                $('#rides').text(result['rides']);
                $('#distance').text(result['distance']);
                $('#rate').css('width',result['rating']);
            }
        });
    }
</script>