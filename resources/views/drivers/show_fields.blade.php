
<!-- Fname Field -->
<div class="form-group">
    {!! Form::label('fname', 'First Name:') !!}
    <p>{!! $driver->first_name !!}</p>
</div>

<!-- Lname Field -->
<div class="form-group">
    {!! Form::label('lname', 'Middle Name:') !!}
    <p>{!! $driver->middle_name !!}</p>
</div>

<div class="form-group">
    {!! Form::label('lname', 'Last Name:') !!}
    <p>{!! $driver->last_name !!}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $driver->email !!}</p>
</div>

<!-- Phone Field -->
<div class="form-group">
    {!! Form::label('phone', 'Phone:') !!}
    <p>{!! $driver->phone !!}</p>
</div>

<!-- Licence Field -->
<div class="form-group">
    {!! Form::label('licence', 'Licence/Car Details:') !!}
    <p><a href="{{url('driver/licence').'/'.$driver->id}}" class="btn btn-info">Details</a></p>
</div>


