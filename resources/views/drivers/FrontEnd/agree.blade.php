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
<div class="container-fluid">
    @include('flash::message')
    <div class="col-md-12 align login-div">
        <div class="col-md-6 col-sm-6">
            <p class="textclr">Alright {{$name}}. <br>You made it! <br> Please accept the terms and conditions and the background check.</p>
            <br>
            <div class="col-md-12 align">
               <center>
                    <div class="col-md-8">
                    <form method="post" action="{{url('driver/agree')}}">
                        {{csrf_field()}}


                        <div class="form-group">
                            <input type="checkbox" name="term" class="checkBox" id="checkbox1" required>
                            <label for="checkbox1" class="CheckText"> I read and accept the terms and conditions</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="bgCheck" class="checkBox" id="checkbox2" required>
                            <label for="checkbox2" class="CheckText"> I accept that ChauffeurX runs a background check on me</label>
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" name="signature" placeholder="Sign your name" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary next-btn">Sign</button>
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
</script>