{{csrf_field()}}
<div class="row field-row form-group">
    <div class="col-sm-6 form-group">
        <label>Coins for Creating the Account</label>
        <input type="text" name="create_account" value="@if(empty($create))0 @else{{$create}} @endif" class="form-control">
    </div>

    <div class="col-sm-6 form-group">
        <label>Coins for Inviting the User</label>
        <input type="text" name="invite" value="@if(empty($invite))0 @else{{$invite}} @endif" class="form-control">
    </div>

    <div class="col-sm-6 form-group">
        <label>Coins for Sharing the App on Social Media</label>
        <input type="text" name="share" value="@if(empty($share))0 @else{{$share}} @endif" class="form-control">
    </div>

    <div class="col-sm-6 form-group">
        <label>Coins for Giving the Tip to Driver</label>
        <input type="text" name="add_tip" value="@if(empty($add_tip))0 @else{{$add_tip}} @endif" class="form-control">
    </div>

    <div class="col-sm-6 form-group">
        <label>Coins for Adding Driver as Favorite</label>
        <input type="text" name="add_fav" value="@if(empty($add_fav))0 @else{{$add_fav}} @endif" class="form-control">
    </div>

    <div class="col-sm-6 form-group">
        <label>Coins for Using ChauffeurX in New City</label>
        <input type="text" name="new_city" value="@if(empty($new_city))0 @else{{$new_city}} @endif" class="form-control">
    </div>

    <div class="col-sm-6 form-group">
        <label>Coins for Other Applications (Like Uber)</label>
        <input type="text" name="delete_app" value="@if(empty($delete_app))0 @else{{$delete_app}} @endif" class="form-control">
    </div>

    <div class="col-sm-6 form-group">
        <label>Coins for Using the New Category in Chauffeurx</label>
        <input type="text" name="new_category" value="@if(empty($new_category))0 @else{{$new_category}} @endif" class="form-control">
    </div>
</div>

<div class="form-group row field-row">
    <h3>&ensp;Coins Per Kilometer</h3>
    <div class="form-group col-sm-6">
        <label>Kilo Metres</label>
        <input type="text" name="kilo_meters" value="@if(empty($kilo_meters))0 @else{{$kilo_meters}} @endif" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label>Coins Per Kilometer</label>
        <input type="text" name="coins_km" value="@if(empty($coins_km))0 @else{{$coins_km}} @endif" class="form-control">
    </div>
</div>
<div class="form-group row field-row">
    <h3>&ensp;Coins for Ride</h3>
    <div class="form-group col-sm-6">
        <label>Number of Rides</label>
        <input type="text" name="rides" value="@if(empty($rides))0 @else{{$rides}} @endif" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label>Coins For Rides</label>
        <input type="text" name="coins_ride" value="@if(empty($coins_ride))0 @else{{$coins_ride}} @endif" class="form-control">
    </div>
</div>
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-primary">Save</button>
</div>