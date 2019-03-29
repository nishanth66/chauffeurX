<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Terms Field -->
<div class="form-group col-sm-12">
    {!! Form::label('max_time', 'Maximum time for free Cancellation (in Minutes):') !!}
    {!! Form::text('max_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('cencellations.index') !!}" class="btn btn-default">Cancel</a>
</div>
