<!-- Userid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('userid', 'Userid:') !!}
    {!! Form::number('userid', null, ['class' => 'form-control']) !!}
</div>

<!-- Cardno Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cardNo', 'Cardno:') !!}
    {!! Form::text('cardNo', null, ['class' => 'form-control']) !!}
</div>

<!-- Fingerprint Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fingerprint', 'Fingerprint:') !!}
    {!! Form::text('fingerprint', null, ['class' => 'form-control']) !!}
</div>

<!-- Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('token', 'Token:') !!}
    {!! Form::text('token', null, ['class' => 'form-control']) !!}
</div>

<!-- Brand Field -->
<div class="form-group col-sm-6">
    {!! Form::label('brand', 'Brand:') !!}
    {!! Form::text('brand', null, ['class' => 'form-control']) !!}
</div>

<!-- Customerid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customerId', 'Customerid:') !!}
    {!! Form::text('customerId', null, ['class' => 'form-control']) !!}
</div>

<!-- Digits Field -->
<div class="form-group col-sm-6">
    {!! Form::label('digits', 'Digits:') !!}
    {!! Form::text('digits', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('passengerStripes.index') !!}" class="btn btn-default">Cancel</a>
</div>
