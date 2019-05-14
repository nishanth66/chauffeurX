<!-- Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('type', 'Notification Type:') !!}
    <select class="form-control" name="type">
        <option value="" selected disabled>Select a Type</option>
        <option value="system" <?php if (isset($template) && $template->type == 'system') { echo "selected"; } ?>>System</option>
        <option value="promotion" <?php if (isset($template) && $template->type == 'promotion') { echo "selected"; } ?>>Promotion</option>
    </select>
</div>

<!-- Title Field -->
<div class="form-group col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    <select name="title" class="form-control">
        <option value="" selected disabled>Select a Title</option>
        <option value="Ride Confirm" <?php if (isset($template) && $template->title == 'Booking Confirm') { echo "selected";}?>>Booking Confirm</option>
        <option value="Ride Cancel" <?php if (isset($template) && $template->title == 'Booking Cancel') { echo "selected";}?>>Ride Cancel</option>
        <option value="Reject Ride" <?php if (isset($template) && $template->title == 'Booking Cancel') { echo "selected";}?>>Reject Ride</option>
    </select>
{{--    {!! Form::text('title', null, ['class' => 'form-control']) !!}--}}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', 'Notification Icon:') !!}
    <input type="file" name="image" class="form-control">
    <div id="image">
        @if(isset($template) && ($template->image != '' || !empty($template->image)))
            <img src="{{asset('public/avatars').'/'.$template->image}}" class="show-image">
        @endif
    </div>
</div>

<!-- Message Field -->
<div class="form-group col-sm-12">
    <label>Mesage:  </label><br/><p id="bookingEx">For Ex:- Your Booking #xxx (xxx will be replaced by booking id) Is successfully Placed! </p>
    {!! Form::textarea('message', null, ['class' => 'form-control','rows'=>4,'cols'=>50,'onfocus'=>'return $("#bookingEx").show()','onchange'=>'return $("#bookingEx").hide()']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('templates.index') !!}" class="btn btn-default">Cancel</a>
</div>
