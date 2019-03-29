<!-- Fname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fname', 'Fname:') !!}
    {!! Form::text('fname', null, ['class' => 'form-control']) !!}
</div>

<!-- Lname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lname', 'Lname:') !!}
    {!! Form::text('lname', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::text('image', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Car No Field -->
<div class="form-group col-sm-6">
    {!! Form::label('car_no', 'Car No:') !!}
    {!! Form::text('car_no', null, ['class' => 'form-control']) !!}
</div>

<!-- Licence Field -->
<div class="form-group col-sm-6">
    {!! Form::label('licence', 'Licence:') !!}
    {!! Form::text('licence', null, ['class' => 'form-control']) !!}
</div>

<!-- Isavailable Field -->
<div class="form-group col-sm-6">
    {!! Form::label('isAvailable', 'Isavailable:') !!}
    {!! Form::text('isAvailable', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('drivers.index') !!}" class="btn btn-default">Cancel</a>
</div>
