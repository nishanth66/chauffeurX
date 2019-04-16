<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $payments->id !!}</p>
</div>

<!-- Booking Id Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $payments->name !!}</p>
</div>

<!-- Userid Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $payments->description !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $payments->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $payments->updated_at !!}</p>
</div>

