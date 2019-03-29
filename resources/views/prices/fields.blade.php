<!-- Category Field -->
<div class="form-group col-sm-12">
    {!! Form::label('category', 'Category:') !!}
    <select class="form-control" name="category" id="category">
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
