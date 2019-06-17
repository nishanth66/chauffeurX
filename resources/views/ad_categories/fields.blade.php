<!-- City Field -->
<div class="form-group col-sm-12">
    {!! Form::label('city', 'City:') !!}
    <select name="city" class="form-control">
        <option value="" selected disabled>Select a City</option>
        @foreach($cities as $city)
            <option value="{{$city->city}}" <?php if(isset($adCategory) && $adCategory->city == $city->city) { echo "selected"; } ?>>{{$city->city}}</option>
        @endforeach
    </select>
</div>

<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Category Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('adCategories.index') !!}" class="btn btn-default">Cancel</a>
</div>
