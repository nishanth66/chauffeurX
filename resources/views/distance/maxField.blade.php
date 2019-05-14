<!-- City Field -->
<div class="form-group col-sm-12">
    {!! Form::label('city', 'City:') !!}
    <select name="city" class="form-control">
        <option value="" selected disabled>Select a City</option>
        @foreach($cities as $city)
            <option value="{{$city->city}}" <?php if(isset($distance) && $distance->city == $city->city) { echo "selected"; } ?>>{{$city->city}}</option>
        @endforeach
    </select>
</div>


<div class="form-group col-sm-12">
    {!! Form::label('car', 'Near by Car Distance:') !!}
    {!! Form::text('car', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('ads', 'Near by Advertisement Distance:') !!}
    {!! Form::text('ads', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('maximumDistance.index') !!}" class="btn btn-default">Cancel</a>
</div>
