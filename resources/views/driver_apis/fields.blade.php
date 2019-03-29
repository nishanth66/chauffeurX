<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Link Field -->
<div class="form-group col-sm-12">
    {!! Form::label('link', 'Link:') !!}
    {!! Form::text('link', 'http://54.189.228.35/api/driver/', ['class' => 'form-control']) !!}
</div>

<!-- Method Field -->
<div class="form-group col-sm-12">
    {!! Form::label('method', 'Method:') !!}
    {!! Form::text('method', null, ['class' => 'form-control']) !!}
</div>

<!-- Parameters Field -->
<div class="form-group col-sm-12">
    {!! Form::label('parameters', 'Parameters:') !!}
    {!! Form::textarea('parameters', null, ['class' => 'form-control','rows'=>5,'cols'=>50]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('driverApis.index') !!}" class="btn btn-default">Cancel</a>
</div>
