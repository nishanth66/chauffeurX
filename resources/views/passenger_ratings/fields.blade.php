<!-- Bookingid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bookingid', 'Bookingid:') !!}
    {!! Form::text('bookingid', null, ['class' => 'form-control']) !!}
</div>

<!-- Userid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('userid', 'Userid:') !!}
    {!! Form::text('userid', null, ['class' => 'form-control']) !!}
</div>

<!-- Driverid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('driverid', 'Driverid:') !!}
    {!! Form::text('driverid', null, ['class' => 'form-control']) !!}
</div>

<!-- Rating Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rating', 'Rating:') !!}
    {!! Form::text('rating', null, ['class' => 'form-control']) !!}
</div>

<!-- Comments Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comments', 'Comments:') !!}
    {!! Form::text('comments', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('passengerRatings.index') !!}" class="btn btn-default">Cancel</a>
</div>
