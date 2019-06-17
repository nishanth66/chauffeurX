<!-- City Field -->
<div class="form-group col-sm-12">
    {!! Form::label('city', 'City:') !!}
    <select name="city" class="form-control">
        <option value="" selected disabled>Select a City</option>
        @foreach($cities as $city)
            <option value="{{$city->city}}" <?php if(isset($penalty) && $penalty->city == $city->city) { echo "selected"; } ?>>{{$city->city}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-sm-12">
    {!! Form::label('penalty', 'Driver Penalty:') !!}
    {!! Form::text('penalty', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{!! route('basicFares.index') !!}" class="btn btn-default">Cancel</a>
</div>