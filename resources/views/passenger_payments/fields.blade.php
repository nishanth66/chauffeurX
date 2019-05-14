<!-- Userid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('userid', 'Userid:') !!}
    {!! Form::text('userid', null, ['class' => 'form-control']) !!}
</div>

<!-- Bookingid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bookingid', 'Bookingid:') !!}
    {!! Form::text('bookingid', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Cardid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cardid', 'Cardid:') !!}
    {!! Form::text('cardid', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('passengerPayments.index') !!}" class="btn btn-default">Cancel</a>
</div>
