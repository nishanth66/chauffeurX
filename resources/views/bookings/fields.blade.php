<!-- Userid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('userid', 'Userid:') !!}
    {!! Form::text('userid', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Completed Field -->
<div class="form-group col-sm-6">
    {!! Form::label('completed', 'Completed:') !!}
    {!! Form::text('completed', null, ['class' => 'form-control']) !!}
</div>

<!-- Source Field -->
<div class="form-group col-sm-6">
    {!! Form::label('source', 'Source:') !!}
    {!! Form::text('source', null, ['class' => 'form-control']) !!}
</div>

<!-- Destination Field -->
<div class="form-group col-sm-6">
    {!! Form::label('destination', 'Destination:') !!}
    {!! Form::text('destination', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Distance Field -->
<div class="form-group col-sm-6">
    {!! Form::label('distance', 'Distance:') !!}
    {!! Form::text('distance', null, ['class' => 'form-control']) !!}
</div>

<!-- Trip Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('trip_date', 'Trip Date:') !!}
    {!! Form::text('trip_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Trip Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('trip_time', 'Trip Time:') !!}
    {!! Form::text('trip_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Source Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('source_description', 'Source Description:') !!}
    {!! Form::text('source_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Destination Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('destination_description', 'Destination Description:') !!}
    {!! Form::text('destination_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Alternate Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alternate_phone', 'Alternate Phone:') !!}
    {!! Form::text('alternate_phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Statu Field -->
<div class="form-group col-sm-6">
    {!! Form::label('statu', 'Statu:') !!}
    {!! Form::text('statu', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::text('image', null, ['class' => 'form-control']) !!}
</div>

<!-- Payment Field -->
<div class="form-group col-sm-6">
    {!! Form::label('payment', 'Payment:') !!}
    {!! Form::text('payment', null, ['class' => 'form-control']) !!}
</div>

<!-- Paid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('paid', 'Paid:') !!}
    {!! Form::text('paid', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('bookings.index') !!}" class="btn btn-default">Cancel</a>
</div>
