<!-- City Field -->
<div class="form-group col-sm-12">
    {!! Form::label('city', 'City:') !!}
    <select name="city" class="form-control" required>
        <option value="" selected disabled>Select a City</option>
        @foreach($cities as $city)
            <option value="{{$city->city}}" <?php if(isset($adSettings) && $adSettings->city == $city->city) { echo "selected"; } ?>>{{$city->city}}</option>
        @endforeach
    </select>
</div>

<!-- View Cost Field -->
<div class="form-group col-sm-12">
    {!! Form::label('view_cost', 'Cost per impression:') !!}
    {!! Form::text('view_cost', null, ['class' => 'form-control']) !!}
</div>

<!-- Category View Cost Field -->
<div class="form-group col-sm-12">
    {!! Form::label('category_view_cost', 'Cost per impression in a filtered category:') !!}
    {!! Form::text('category_view_cost', null, ['class' => 'form-control']) !!}
</div>

<!-- Max Distance Field -->
<div class="form-group col-sm-12">
    {!! Form::label('max_distance', 'Maximum Distance (in Kms):') !!}
    {!! Form::text('max_distance', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('adSettings.index') !!}" class="btn btn-default">Cancel</a>
</div>
