<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('city', 'City:') !!}
    <select name="city" class="form-control">
        <option value="" selected disabled>Select a City</option>
        @foreach($cities as $city)
            <option value="{{$city->city}}" <?php if(isset($categories) && $categories->city == $city->city) { echo "selected"; } ?>>{{$city->city}}</option>
        @endforeach
    </select>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'Category Description']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    @if(isset($categories) && $categories != '')
        <textarea class="form-control" name="description" cols="50" rows="5">{{$categories->description}}</textarea>
    @else
        <textarea class="form-control" name="description" cols="50" rows="5"></textarea>
    @endif
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <input type="file" class="form-control" name="image" placeholder="Category Image" onchange="readURL(this)"> <br/>
    <div id="image">
        @if(isset($categories) && $categories != '')
            @if(isset($categories->image))
                <img src="{{asset('public/avatars').'/'.$categories->image}}" class="show-image">
            @endif
        @endif
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('categories.index') !!}" class="btn btn-default">Cancel</a>
</div>
{{--@section('css')--}}
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var html = '<br/><img class="show-image" src="' + e.target.result + '">';
                    $('#image')
                        .html(html);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
{{--@endsection--}}