@include('drivers.FrontEnd.topbar')
<style>
    .checkBox{
        width: 22px;
        height: 22px;
        background: white !important;
        border: 1px solid #4D68B0 !important;
    }
    .CheckText{
        font-size: medium;
        color: #4D68B0;
        padding-left: 10px;
    }
</style>
<div class="container-fluid">
    <div class="col-md-12 align">
        <div class="col-md-6 col-sm-6">
            <p class="textclr">Alright FIRST NAME. <br>You made it! <br> Please accept the terms and conditions and the background check.</p>
            <br>
            <div class="col-md-12 align">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="form-group" style="display:flex;">
                        <input type="checkbox" class="checkBox" id="checkbox1">
                        <label for="checkbox1" class="CheckText"> I read and accept the terms and conditions</label>
                    </div>
                    <div class="form-group" style="display:flex;">
                        <input type="checkbox" class="checkBox" id="checkbox2">
                        <label for="checkbox2" class="CheckText"> I accept that ChauffeurX runs a background check on mr</label>
                    </div>
                    <div class="form-group">
                        <input class="form-control1" type="text" name="sign_your_name" placeholder="Sign your name">
                    </div>
                    <div class="form-group">
                        <button type="button" name="sign" class="btn btn-primary next-btn">Sign</button>
                    </div>
                </div>
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