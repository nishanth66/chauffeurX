<div class="loader" id="loader-2">
    <span></span>
    <span></span>
    <span></span>
</div>
<div class="overlay" id="overlay"></div>
@include('drivers.FrontEnd.header')
@include('advertisements.FrontEnd.sideBar')
<style>
    @media (min-width: 600px) and (max-width: 601px) {
        .switch
        {
            right: 70px !important;
        }
        .slider:before {
            left: 10px !important;
        }
        .delete
        {
            right: 85px !important;
        }
        .edit-ad
        {
            right: 84px !important;
        }
    }
</style>
<center>
    {{--<div class="col-md-6 col-sm-6 col-xs-10">--}}
        @include('flash::message')
    <div class="alert alert-success" id="alertDiv"></div>
    {{--</div>--}}
</center>
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
<div class="row">
    @if(count($advertisements)>=1)
        @foreach($advertisements as $advertisement)
            <?php
                $baseViews = 0;
                $catViews = 0;
                if (\App\Models\AdView::where('adId',$advertisement->id)->whereDate('created_at','>',\Carbon\Carbon::now()->subDays(7))->exists())
                {
                    $baseViews = \App\Models\AdView::where('adId',$advertisement->id)->whereDate('created_at','>',\Carbon\Carbon::now()->subDays(7))->sum('base_view');
                    $catViews = \App\Models\AdView::where('adId',$advertisement->id)->whereDate('created_at','>',\Carbon\Carbon::now()->subDays(7))->sum('category_view');
                    $adCost = \App\Models\AdView::where('adId',$advertisement->id)->whereDate('created_at','>',\Carbon\Carbon::now()->subDays(7))->sum('ad_cost');
                }
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12" id="ads{{$advertisement->id}}">
            <div class="col-md-1 col-sm-1 col-xs-1"></div>
            <div class="col-md-8 col-sm-8 col-xs-10">
                <div class="col-md-2 col-sm-2 col-xs-2 align">
                    <label class="switch">
                        <input type="checkbox" id="toggleCheckbox{{$advertisement->id}}" @if($advertisement->visible == 1) checked @endif onchange="checkBoxValue('{{$advertisement->id}}')">
                        <span class="slider round"></span>
                    </label>
                    <button class="btn btn-default btn-xs delete" onclick="deleteAd('{{$advertisement->id}}')"><i class="fa fa-trash-o"></i></button> <br class="mobile"/>
                    <a class="btn btn-default btn-xs edit-ad" href="{{url('advertisement/edit').'/'.$advertisement->id}}"><i class="fa fa-pencil"></i></a>
                </div>
                <div class="col-md-5">
                    @if(isset($advertisement->image) && !empty($advertisement->image))
                        <img class="cimg" src="{{asset('public/avatars').'/'.$advertisement->image}}">
                    @else
                        <img class="cimg" src="{{asset('public/image/no_image.jpg')}}">
                    @endif
                    <p class="chaufferxpara">
                        {{$advertisement->description}}
                    </p>
                </div>
                <div class="col-md-3 col-xs-6 chaufferxpara para1">
                    Base ad views
                </div>
                <div class="col-md-2 col-xs-6 chaufferxpara para1" id="view{{$advertisement->id}}">
                    {{$baseViews}}
                </div>
                <div class="col-md-3 col-xs-6 chaufferxpara para1">
                    Category views
                </div>
                <div class="col-md-2 col-xs-6 chaufferxpara para1">
                    {{$catViews}}
                </div>
                <div class="col-md-3 col-xs-6 chaufferxpara para1">
                    ad cost
                </div>
                <div class="col-md-2 col-xs-6 chaufferxpara para1">
                    &dollar;{{$adCost}}
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-1"></div>
        </div>
        @endforeach
    @else
        <div class="row">
            <div class="col-md-2 col-sm-2"></div>
            <div class="col-sm-8 col-md-8 col-xs-12">
                <center>
                    <h3>No ads are found!</h3>
                    <h3><a class="login-anchor" href="{{url('advertisement/create')}}">Click here</a> to Create one</h3>
                </center>
            </div>
            <div class="col-md-2 col-sm-2"></div>

        </div>
    @endif
</div>
{{--<div class="row">--}}
    {{--<center>--}}
        {{--<div>--}}
            {{--{{$advertisements->render()}}--}}
        {{--</div>--}}
    {{--</center>--}}
{{--</div>--}}
<div class="row home-row-ad">

</div>

</div>
</div>

<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
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
        $('.loader').show();
        $.ajax({
            url: "{{url('advertisement/changeData')}}"+"/"+val,
            success: function(result)
            {
                $('.loader').hide();
                $.each(result, function(key, value) {
                    if (key != 'message')
                    {
                        $('#view'+key).text(result[key]['views']);
                    }
                });
                $.toast({
                    heading: '',
                    text: result['message'],
                    icon: 'info',
                    hideAfter: 5000,
                    showHideTransition: 'slide',
                    loader: false
                })
            },
            error: function(error)
            {
                $('.loader').hide();
                $.toast({
                    heading: 'Failed',
                    text: "Couldn't fetch the data.",
                    icon: 'error',
                    hideAfter: 5000,
                    showHideTransition: 'slide',
                    loader: false
                })
            }
        });
    }

    function checkBoxValue(id) {
        if ($('#toggleCheckbox'+id).is(":checked"))
        {
            var visible = 1;
        }
        else
        {
            var visible = 0;
        }
        if (confirm("Are you sure?"))
        {
            $('.loader').show();
            $.ajax({
               url: "{{url('advertisement/visible')}}"+"/"+visible+"/"+id,
               success: function (res) {
                   if (res == 0)
                   {
                       $('#toggleCheckbox'+id).prop('checked', !$('#toggleCheckbox'+id).prop('checked'));
                       $.toast({
                           heading: 'Failed',
                           text: 'Your Maximum Daily Budget is reached.',
                           icon: 'error',
                           hideAfter: 5000,
                           showHideTransition: 'slide',
                           loader: false
                       });
                       $('.loader').hide();
                   }
                   else
                   {
                       $('.loader').hide();
                       if (visible == 1) {
                           $.toast({
                               heading: 'Success',
                               text: 'Your ad is Visible.',
                               icon: 'success',
                               hideAfter: 5000,
                               showHideTransition: 'slide',
                               loader: false
                           })
                       }
                       else {
                           $.toast({
                               heading: 'Success',
                               text: 'Your ad is not Visible.',
                               icon: 'success',
                               hideAfter: 5000,
                               showHideTransition: 'slide',
                               loader: false
                           })
                       }
                   }
               }
            });
        }
        else
        {
            $('#toggleCheckbox'+id).prop('checked', !$('#toggleCheckbox'+id).prop('checked'));
        }
    }
    function deleteAd(id) {
        if (confirm("Are you sure?"))
        {
            $('.loader').show();
            $.ajax({
                url: "{{url('advertisement/delete')}}",
                data: {id:id,_token:"{{csrf_token()}}"},
                type: "POST",
                success: function (result) {
                    if (result == 1)
                    {
                        $('.loader').hide();
                        $('#ads'+id).remove();
                        $.toast({
                            heading: 'Success',
                            text: 'Advertisement Deleted.',
                            icon: 'success',
                            hideAfter: 5000,
                            showHideTransition: 'slide',
                            loader: false
                        })

                    }
                }
            });
        }
    }
</script>