@include('drivers.FrontEnd.topbar')
<style>
    .form-control{
        color: #4D68B0 !important;
    }
</style>
<div class="container-fluid">
    <div class="col-md-12 align">
        <div class="col-md-4">
            <p class="textclr login-div"> Hi FIRST NAME, <br> Where do you live?</p>
            <br>
            <center>
                <div class="col-md-12">
                    <div class="form-group">
                        <input class="form-control1" type="text" name="address" placeholder="your address">
                    </div>
                    <div class="form-group">
                        <input class="form-control1" type="text" name="apartment_no" placeholder="your apartment number">
                    </div>
                    <div class="form-group">
                        <input class="form-control1" type="text" name="city" placeholder="your city">
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" name="state" placeholder="your state">
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" name="zip" placeholder="your ZIP code">
                        </div>
                        <div class="form-group">
                            <input class="form-control1" type="text" name="country" placeholder="your country">
                        </div>
                    <div class="form-group">
                        <button type="button" name="next" class="btn btn-primary next-btn">Next</button>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>