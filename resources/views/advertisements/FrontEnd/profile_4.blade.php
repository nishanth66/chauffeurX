@include('drivers.FrontEnd.topbar')
<style>
    .license{
        width: 100%;height: 200px;
        /*object-fit: contain;*/
    }
    .btn-edit{
        position: absolute;
        top: 0;
        right: -25px;
        background: transparent;
        border: none;
        padding: 2px;
        font-size: larger;
    }
</style>
<div class="container-fluid">
    <div class="col-md-12 align">
        <div class="col-md-4 col-sm-6">
            <p class="textclr">Thanks FIRST NAME.<br> Now upload your driver's license <br> <br> If you don't have it with you, you can come back later, login and you will get to this very page</p>
            <br>
            <center>
                <div class="col-md-12">
                    <div class="form-group" style="position: relative;">
                        <img src="{{asset('public/image/new-drivers-license-dmv.png')}}" class="license" id="preview">
                        {{--<img src="{{asset('public/image/Document.png')}}" class="license" id="preview">--}}
                        <button type="button" class="btn-edit" onclick="triggerUpload()"><i class="fa fa-pencil"></i></button>
                        <input type="file" name="license" style="display: none;" id="license">
                    </div>
                    <div class="form-group">
                        <button type="button" name="next" class="btn btn-primary next-btn">Next</button>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
<script>
    function triggerUpload() {
        $('#license').trigger('click');
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
    $("#license").change(function() {
        readURL(this);
    });
</script>