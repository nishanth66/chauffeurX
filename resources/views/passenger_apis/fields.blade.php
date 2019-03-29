<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Link Field -->
<div class="form-group col-sm-12">
    {!! Form::label('link', 'Link:') !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
</div>

<!-- Method Field -->
<div class="form-group col-sm-12">
    {!! Form::label('method', 'Method:') !!}
    {!! Form::text('method', null, ['class' => 'form-control']) !!}
</div>

<!-- Parameters Field -->
<div class="form-group col-sm-12">
    {!! Form::label('parameters', 'Parameters:') !!}
    @if(isset($passengerApi) && $passengerApi->parameters)
        <textarea name="parameters" class="form-control" cols="50" rows="5">{{$passengerApi->parameters}}</textarea>
    @else
        <textarea name="parameters" class="form-control" cols="50" rows="5"></textarea>
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('passengerApis.index') !!}" class="btn btn-default">Cancel</a>
</div>
