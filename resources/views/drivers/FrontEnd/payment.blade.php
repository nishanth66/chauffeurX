<div class="loader" id="loader-2">
    <span></span>
    <span></span>
    <span></span>
</div>
<div class="overlay" id="overlay"></div>
@include('drivers.FrontEnd.header')
@include('drivers.FrontEnd.sideBar')
<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<div class="row">
    <form action="" name="someform">

        <div class="col-md-12 col-xs-12 col-sm-12 form-container">
            <div class="col-md-4 col-xs-12 col-sm-4">
                <h5 class="loginAnchor form-group">Membership Price: $49</h5>
                <h5 class="loginAnchor">Credit Card Information</h5>
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
                <button class="btn btn-primary" id="input-button" type="button">Pay and Save</button>
            </div>
        </div>
    </form>
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
            url: "{{url('driver/payment')}}",
            type: "post",
            data: {card_no:card, ccExpiryMonth:month, ccExpiryYear: year, cvvNumber:cvv, _token:'{{csrf_token()}}'},
            success:function (result) {
                console.log(result);
                $('.loader').hide();
                if (result['code'] == 1)
                {
                    $.toast({
                        heading: 'Success',
                        text: result['message'],
                        icon: 'success',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    });
                    window.location.href = "{{url('home')}}";
                }
                else if (result['code'] == 2)
                {
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
                    text: "Could not complete the payment.",
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