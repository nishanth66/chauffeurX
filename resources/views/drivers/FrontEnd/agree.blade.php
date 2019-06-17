@include('drivers.FrontEnd.topbar')
<style>
    .checkBox{
        width: 22px;
        height: 22px;
        background: white !important;
        border: 1px solid #4D68B0 !important;
        position: absolute;
        left:0;
    }
    .CheckText{
        font-size: medium;
        color: #4D68B0;
        padding-left: 10px;
        text-align: justify;
    }
</style>
<div class="row row-master"></div>
<div class="container-fluid">

    <div class="col-md-12 align login-div">
        <div class="col-md-6 col-sm-6">
            @include('flash::message')
            <p class="textclr">Alright {{$name}}. <br>You made it! <br> Please accept the terms and conditions and the background check.</p>
            <br>
            <div class="col-md-12 align">
               <center>
                    <div class="col-md-8">
                    <form method="post" action="{{url('driver/agree')}}">
                        {{csrf_field()}}


                        <div class="form-group">
                            <input type="checkbox" name="term" class="checkBox error" id="checkbox1" @if(isset($driver) && $driver->signature != '') checked @endif>
                            <label for="checkbox1" class="CheckText"> I read and accept the terms and conditions</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="bgCheck" class="checkBox" id="checkbox2" @if(isset($driver) && $driver->signature != '') checked @endif>
                            <label for="checkbox2" class="CheckText"> I accept that ChauffeurX runs a background check on me</label>
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" name="signature" id="sign" placeholder="Sign your name" required value="{{$driver->signature}}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary next-btn" id="btnNext">Sign</button>
                        </div>
                    </form>
                </div>
               </center>
            </div>

        </div>
    </div>
</div>
<script>
    function triggerUpload() {
        $('#document').trigger('click');
    }
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#document").change(function() {
        readURL(this);
    });
    $(document).ready(function() {
        $('.alert-success').hide();
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
        $('.alert-danger').hide();
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
    });
</script>
<script>
    $('#btnNext').click(function (e) {
        if ($('#checkbox1').is(':checked') == 0)
        {
            e.preventDefault();
            $.toast({
                heading: '',
                text: "You need to agree to the terms and conditions",
                icon: 'info',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            return false;
        }
        else if ($('#checkbox2').is(':checked') == 0)
        {
            e.preventDefault();
            $.toast({
                heading: '',
                text: "You need to agree to the background verification",
                icon: 'info',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            return false;
        }
        else if ($('#sign').val() == '')
        {
            e.preventDefault();
            $.toast({
                heading: '',
                text: "You need to sign your name",
                icon: 'info',
                hideAfter: 5000,
                showHideTransition: 'slide',
                loader: false
            });
            return false;
        }

    });
</script>