<!-- City Field -->
<div class="form-group col-sm-12">
    {!! Form::label('city', 'City:') !!}
    <select class="form-control" name="city" onchange="setCategory(this.value)">
        <option value="" selected disabled>Select a city</option>
        @foreach($cities as $city)
            <option value="{{$city->id}}" @if(isset($driverSubscription) && $driverSubscription->city == $city->city) selected @endif>{{$city->city}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-sm-12" id="category">
    @if(isset($driverSubscription))
        <?php
        $categories = \App\Models\categories::where('city','like',$driverSubscription->city)->get();
        ?>
        {!! Form::label('category', 'Category:') !!}
        <select name="category" class="form-control">
            <option value="" selected disabled>Select a Category</option>
            @foreach($categories as $category)
                <option value="{{$category->id}}" <?php if(isset($driverSubscription) && $driverSubscription->category == $category->id) { echo "selected"; } ?>>{{$category->name}}</option>
            @endforeach
        </select>
    @endif
</div>
<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('driverSubscriptions.index') !!}" class="btn btn-default">Cancel</a>
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