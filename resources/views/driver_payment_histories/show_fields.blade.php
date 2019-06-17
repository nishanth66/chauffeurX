<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $driverPaymentHistory->id !!}</p>
</div>

<!-- Driverid Field -->
<div class="form-group">
    {!! Form::label('driverid', 'Driverid:') !!}
    <p>{!! $driverPaymentHistory->driverid !!}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{!! $driverPaymentHistory->amount !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $driverPaymentHistory->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $driverPaymentHistory->updated_at !!}</p>
</div>

