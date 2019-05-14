<!-- Category Field -->
<div class="form-group col-sm-12">
    {!! Form::label('city', 'City:') !!}
    <select name="city" class="form-control" onchange="setCategory(this.value)">
        <option value="" selected disabled>Select a City</option>
        @foreach($cities as $city)
            <option value="{{$city->id}}" <?php if(isset($price) && $price->city == $city->id) { echo "selected"; } ?>>{{$city->city}}</option>
        @endforeach
    </select>
</div>

<div class="form-group col-sm-12" id="category">
    @if(isset($price))
        {!! Form::label('category', 'Category:') !!}
        <select class="form-control" name="category">
            <option value="" selected disabled>Select a Category</option>
            @if(isset($price) && $price->category != '')
                @foreach($categories as $category)
                    <option value="{{$category->id}}" <?php if ($price->category == $category->id) { echo "selected"; } ?>>{{$category->name}}</option>
                @endforeach
            @else
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            @endif
        </select>
    @endif
</div>

<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount per Kilometer:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('prices.index') !!}" class="btn btn-default">Cancel</a>
</div>

@section('scripts')
<script>
    function setCategory(val) {
        $.ajax({
            url: "{{url('fetchCityCategory')}}"+"/"+val,
            success: function(result)
            {
                $("#category").html(result);
            }
        });
    }
</script>
@endsection