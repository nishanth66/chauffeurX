
<div class="form-group col-sm-12">
    {!! Form::label('distance', 'Distance to display Closest Driver (in Kms):') !!}
    {!! Form::text('distance', null, ['class' => 'form-control','placeholer' => 'Distance to display Closest Driver (in Kms)','required']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('driverDistance.index') !!}" class="btn btn-default">Cancel</a>
</div>
