<div class="overlay" id="overlay"></div>
<div class="loader" id="loader-2">
    <span></span>
    <span></span>
    <span></span>
</div>
@include('drivers.FrontEnd.header')
@include('drivers.FrontEnd.sideBar')
<style>
    .license{
        width: 280px;
        height: 190px;
    }
    #content
    {
        padding: 0;
    }
    @media (max-width: 768px) {
        .license {
            width: 190px;
            height: 150px;
        }
    }
    @media (max-width: 320px) {
        .license {
            width: 129px;
            height: 120px;
        }
    }
</style>
        <center>
            <form id="upcomingEdit" method="post">
                <input type="hidden" name="driverid" value="{{$driver->id}}">
                <center>
                    <div class="col-md-1 col-sm-1"></div>
                    <div class="row col-md-10 col-sm-10 col-xs-12 driver-edit-docs">
                    <div class="col-md-6 col-sm-6-col-xs-12">
                        Car Inspection: Expires 12/23/2019<i class="fa fa-pencil docs-edit-pencil" onclick="return $('#inspection').trigger('click');"></i>
                        <div class="form-group" style="position: relative;">
                            @if(isset($documents) && $documents->car_inspection != '' || !empty($documents->car_inspection))
                                <img src="{{asset('public/avatars').'/'.$documents->car_inspection}}" class="license" id="insp">
                            @else
                                <img src="{{asset('public/image/new-drivers-license-dmv.png')}}" class="license" id="insp">
                            @endif
                            <input type="file" name="car_inspection" style="display: none;" id="inspection" accept="image/*" onchange="readURL(this)">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6-col-xs-12">
                        Car Insurance: Expires 09/22/2019<i class="fa fa-pencil docs-edit-pencil" onclick="return $('#insurance').trigger('click');"></i>
                        <div class="form-group" style="position: relative;">
                            @if(isset($documents) && $documents->car_insurance != '' || !empty($documents->car_insurance))
                                <img src="{{asset('public/avatars').'/'.$documents->car_insurance}}" class="license" id="preview2">
                            @else
                                <img src="{{asset('public/image/insurance.png')}}" class="license" id="preview2">
                            @endif
                            <input type="file" name="car_insurance" style="display: none;" id="insurance" accept="image/*" onchange="readURL2(this)">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6-col-xs-12">
                        Car Registration: Expires 06/12/2019<i class="fa fa-pencil docs-edit-pencil" onclick="return $('#reg').trigger('click');"></i>
                        <div class="form-group" style="position: relative;">
                            @if(isset($documents) && $documents->car_reg != '' || !empty($documents->car_reg))
                                <img src="{{asset('public/avatars').'/'.$documents->car_reg}}" class="license" id="preview3">
                            @else
                                <img src="{{asset('public/image/rc.png')}}" class="license" id="preview3">
                            @endif
                            <input type="file" name="car_reg" style="display: none;" id="reg" accept="image/*" onchange="readURL3(this)">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6-col-xs-12">
                        Driver's Licence: Expires 09/22/2020<i class="fa fa-pencil docs-edit-pencil" onclick="return $('#car_licence').trigger('click');"></i>
                        <div class="form-group" style="position: relative;">
                            @if(isset($documents) && $documents->driving_licence != '' || !empty($documents->driving_licence))
                                <img src="{{asset('public/avatars').'/'.$documents->driving_licence}}" class="license" id="preview4">
                            @else
                                <img src="{{asset('public/image/rc.png')}}" class="license" id="preview4">
                            @endif
                            <input type="file" name="driving_licence" style="display: none;" id="car_licence" accept="image/*" onchange="readURL4(this)">
                        </div>
                    </div>
                </div>
                    <div class="col-md-1 col-sm-1"></div>
                </center>
            </form>
        </center>

</div>
</div>


<!-- jQuery CDN - Slim version (=without AJAX) -->
{{--<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="{{asset('public/js/swipe.js')}}"></script>
<!-- Bootstrap JS -->
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}

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
    });
    function readURL(input) {
        $('.loader').show();
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#insp').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        var form = $('#upcomingEdit')[0];
//        var image = $("#license")[0].files[0];
        var data = new FormData(form);
        data.append("_token", "{{csrf_token()}}");
//        var driverid = $('#driverid').val();
        $.ajax({
            type: "POST",
            url: "{{url('driver/upcoming')}}",
            data: data,
            processData: false,
            contentType: false,
            success: function(result) {
                $('#upcomingEdit')[0].reset();
                $('.loader').hide();
                    $.toast({
                        heading: 'Success',
                        text: "Car Inspection is updated",
                        icon: 'success',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    })
            }

        });
    }

    function readURL2(input) {
        $('.loader').show();
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview2').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        var form = $('#upcomingEdit')[0];
//        var image = $("#license")[0].files[0];
        var data = new FormData(form);
        data.append("_token", "{{csrf_token()}}");
//        var driverid = $('#driverid').val();
        $.ajax({
            type: "POST",
            url: "{{url('driver/upcoming')}}",
            data: data,
            processData: false,
            contentType: false,
            success: function(result) {
                $('.loader').hide();
                $('#upcomingEdit')[0].reset();
                $.toast({
                    heading: 'Success',
                    text: "Car Insurance is updated",
                    icon: 'success',
                    hideAfter: 5000,
                    showHideTransition: 'slide',
                    loader: false
                })
            }

        });
    }
    function readURL3(input) {
        $('.loader').show();
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview3').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        var form = $('#upcomingEdit')[0];
//        var image = $("#license")[0].files[0];
        var data = new FormData(form);
        data.append("_token", "{{csrf_token()}}");
//        var driverid = $('#driverid').val();
        $.ajax({
            type: "POST",
            url: "{{url('driver/upcoming')}}",
            data: data,
            processData: false,
            contentType: false,
            success: function(result) {
                $('.loader').hide();
                $('#upcomingEdit')[0].reset();
                $.toast({
                    heading: 'Success',
                    text: "Car Registration is updated",
                    icon: 'success',
                    hideAfter: 5000,
                    showHideTransition: 'slide',
                    loader: false
                })
            }

        });
    }
    function readURL4(input) {
        $('.loader').show();
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview4').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        var form = $('#upcomingEdit')[0];
//        var image = $("#license")[0].files[0];
        var data = new FormData(form);
        data.append("_token", "{{csrf_token()}}");
//        var driverid = $('#driverid').val();
        $.ajax({
            type: "POST",
            url: "{{url('driver/upcoming')}}",
            data: data,
            processData: false,
            contentType: false,
            success: function(result) {
                $('.loader').hide();
                $('#upcomingEdit')[0].reset();
                $.toast({
                    heading: 'Success',
                    text: "Driving Licence is updated",
                    icon: 'success',
                    hideAfter: 5000,
                    showHideTransition: 'slide',
                    loader: false
                })
            }

        });
    }

</script>