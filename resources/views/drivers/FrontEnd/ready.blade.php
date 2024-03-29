@include('drivers.FrontEnd.topbar')
<div class="row row-master"></div>
<div class="container">
        <div class="login-div">
            <center>
                @include('flash::message')
                    <p class="loginAnchor">We received Your Application <br/>
                    Our team will Review it within 2 bussiness days and get back to you</p>
                    <p class="loginAnchor">If you are approved, You will receive an email at<br/>
                    <b><i>{{$driver->email}}</i></b></p> <br/>
                <a href="{{url('home')}}" class="btn btn-primary ready-btn">Get ready</a>
            </center>
        </div>
</div>

<script>
    (function (global) {

        if(typeof (global) === "undefined") {
            throw new Error("window is undefined");
        }

        var _hash = "!";
        var noBackPlease = function () {
            global.location.href += "#";

            // making sure we have the fruit available for juice (^__^)
            global.setTimeout(function () {
                global.location.href += "!";
            }, 50);
        };

        global.onhashchange = function () {
            if (global.location.hash !== _hash) {
                global.location.hash = _hash;
            }
        };

        global.onload = function () {
            noBackPlease();

            // disables backspace on page except on input fields and textarea..
            document.body.onkeydown = function (e) {
                var elm = e.target.nodeName.toLowerCase();
                if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                    e.preventDefault();
                }
                // stopping event bubbling up the DOM tree..
                e.stopPropagation();
            };
        }

    })(window);
    $(document).ready(function() {
        $('.alert-success').hide();
        $('.alert-warning').hide();
        $('.alert-danger').hide();

        if (($('.alert-success').contents().length != 0)) {
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
            $.toast({
                heading: 'Failed',
                text: $('.alert-danger').text(),
                icon: 'error',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            })

        }
        if (($('.alert-warning').contents().length  != 0))
        {
            $.toast({
                heading: '',
                text: $('.alert-warning').text(),
                icon: 'warning',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            })

        }
    });
</script>