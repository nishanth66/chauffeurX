@include('drivers.FrontEnd.topbar')
<style>
    .form-control{
        color: #4D68B0 !important;
    }
</style>
<div class="container-fluid">
    <div class="col-md-12 align">
        <div class="col-md-4">
            <p class="textclr login-div"> Thanks. <br> Now tell us about you </p>
            <br>
            <center>
                <div class="col-md-12">
                    <form method="post" action="{{url('driver/profile')}}">
                        @include('flash::message')
                        {{csrf_field()}}
                        <div class="form-group">
                            <input class="form-control1" type="text" name="first_name" value="{{$driver->first_name}}" placeholder="your first name" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" name="middle_name" value="{{$driver->middle_name}}" placeholder="your middle name">
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" name="last_name" value="{{$driver->last_name}}" placeholder="your last name">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary next-btn">Next</button>
                        </div>
                    </form>
                </div>
            </center>
        </div>
    </div>
</div>