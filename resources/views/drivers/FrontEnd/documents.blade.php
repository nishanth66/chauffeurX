@include('drivers.FrontEnd.topbar')
<style>
    .license{
        width: 100%;height: 200px;
        /*object-fit: contain;*/
    }
</style>
<div class="container-fluid">
    <div class="col-md-12 align login-div">
        <center>
            <form method="post" enctype="multipart/form-data" action="{{url('driver/documents')}}">
                @include('flash::message')
                {{csrf_field()}}
                    <div class="col-md-6 col-sm-6" id="doc1">
                        <p class="textclr">Thanks {{$name}}.<br> Now upload your driver's license <br> <br> If you don't have it with you, you can come back later, login and you will get to this very page</p>
                        <br>
                        <center>

                            <div class="col-md-12">
                                <div class="form-group" style="position: relative;">
                                    @if(isset($driver) && $driver->driving_licence != '' || !empty($driver->driving_licence))
                                        <img src="{{asset('public/avatars').'/'.$driver->driving_licence}}" class="license" id="preview">
                                    @else
                                        <img src="{{asset('public/image/new-drivers-license-dmv.png')}}" class="license" id="preview">
                                    @endif
                                    <button type="button" class="btn-edit" onclick="triggerUpload()"><i class="fa fa-pencil"></i></button>
                                    <input type="file" name="driving_licence" style="display: none;" id="license" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary next-btn" onclick="showDoc('2','1')">Next</button>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="col-md-6 col-sm-6" id="doc2">
                        <p class="textclr">Great!.<br> Now upload your Proof of Insurance <br> <br> If you don't have it with you, you can come back later, login and you will get to this very page</p>
                        <br>
                        <center>

                            <div class="col-md-12">
                                <div class="form-group" style="position: relative;">
                                    @if(isset($driver) && $driver->car_insurance != '' || !empty($driver->car_insurance))
                                        <img src="{{asset('public/avatars').'/'.$driver->car_insurance}}" class="license" id="preview">
                                    @else
                                        <img src="{{asset('public/image/insurance.png')}}" class="license" id="preview2">
                                    @endif
                                    <button type="button" class="btn-edit" onclick="triggerUpload2()"><i class="fa fa-pencil"></i></button>
                                    <input type="file" name="car_insurance" style="display: none;" id="car_insurance" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-next" onclick="showDoc('3','2')">Next</button>
                                    <button type="button" class="btn btn-default btn-back" onclick="showDoc('1','2')">Back</button>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="col-md-6 col-sm-6" id="doc3">
                        <p class="textclr">Perfect!.<br> Let's Validate You Car. Please Upload Your Registration <br> <br> If you don't have it with you, you can come back later, login and you will get to this very page</p>
                        <br>
                        <center>
                            <div class="col-md-12">
                                <div class="form-group" style="position: relative;">
                                    @if(isset($driver) && $driver->car_reg != '' || !empty($driver->car_reg))
                                        <img src="{{asset('public/avatars').'/'.$driver->car_reg}}" class="license" id="preview">
                                    @else
                                        <img src="{{asset('public/image/rc.png')}}" class="license" id="preview3">
                                    @endif
                                    <button type="button" class="btn-edit" onclick="triggerUpload3()"><i class="fa fa-pencil"></i></button>
                                    <input type="file" name="car_reg" style="display: none;" id="car_reg" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-next" onclick="showDoc('4','3')">Next</button>
                                    <button type="button" class="btn btn-default btn-back" onclick="showDoc('2','3')">Back</button>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="col-md-6 col-sm-6" id="doc4">
                        <p class="textclr">Almost There!.<br> Upload Your Car Inspection Document <br>If You had it done for Another app (Uber,Lyft..), we can use it <br> <br> If you don't have it with you, you can come back later, login and you will get to this very page</p>
                        <br>
                        <center>

                            <div class="col-md-12">
                                <div class="form-group" style="position: relative;">
                                    @if(isset($driver) && $driver->car_inspection != '' || !empty($driver->car_inspection))
                                        <img src="{{asset('public/avatars').'/'.$driver->car_inspection}}" class="license" id="preview">
                                    @else
                                        <img src="{{asset('public/image/inspect.png')}}" class="license" id="preview4">
                                    @endif
                                    <button type="button" class="btn-edit" onclick="triggerUpload4()"><i class="fa fa-pencil"></i></button>
                                    <input type="file" name="car_inspection" style="display: none;" id="car_inspection" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-next">Next</button>
                                    <button type="button" class="btn btn-default btn-back" onclick="showDoc('3','4')">Back</button>
                                </div>
                            </div>
                        </center>
                    </div>
            </form>
        </center>
    </div>
</div>
<script>
    function triggerUpload() {
        $('#license').trigger('click');
    }
    function triggerUpload2() {
        $('#car_insurance').trigger('click');
    }
    function triggerUpload3() {
        $('#car_reg').trigger('click');
    }
    function triggerUpload4() {
        $('#car_inspection').trigger('click');
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
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview2').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#car_insurance").change(function() {
        readURL2(this);
    });
    function readURL3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview3').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#car_reg").change(function() {
        readURL3(this);
    });
    function readURL4(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview4').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#car_inspection").change(function() {
        readURL4(this);
    });
    function showDoc(show,hide) {
        $('#doc'+hide).hide();
        $('#doc'+show).show();
    }
</script>