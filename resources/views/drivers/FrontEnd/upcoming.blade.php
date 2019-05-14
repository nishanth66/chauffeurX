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
            <div class="row col-md-11 col-sm-11 col-xs-12 driver-edit-docs">
            <div class="col-md-6 col-sm-6-col-xs-12">
                Car Inspection: Expires 12/23/2019<i class="fa fa-pencil docs-edit-pencil" onclick="triggerUpload()"></i>
                <div class="form-group" style="position: relative;">
                    @if(isset($documents) && $documents->car_inspection != '' || !empty($documents->car_inspection))
                        <img src="{{asset('public/avatars').'/'.$documents->car_inspection}}" class="license" id="preview">
                    @else
                        <img src="{{asset('public/image/new-drivers-license-dmv.png')}}" class="license" id="preview">
                    @endif
                    <input type="file" name="car_inspection" style="display: none;" id="inspection" accept="image/*" onchange="readURL(this)">
                </div>
            </div>
            <div class="col-md-6 col-sm-6-col-xs-12">
                Car Insurance: Expires 09/22/2019<i class="fa fa-pencil docs-edit-pencil" onclick="triggerUpload()"></i>
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
                Car Registration: Expires 06/12/2019<i class="fa fa-pencil docs-edit-pencil" onclick="triggerUpload()"></i>
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
                Driver's Licence: Expires 09/22/2020<i class="fa fa-pencil docs-edit-pencil" onclick="triggerUpload()"></i>
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
        </center>

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

</script>