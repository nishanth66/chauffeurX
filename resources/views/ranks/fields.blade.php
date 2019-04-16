<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <input type="file" name="image" class="form-control">
    <div id="image">
        @if(isset($rank->image) && ($rank->image != '' || !empty($rank->image)))
            <img src="{{asset('public/avatars').'/'.$rank->image}}" clas="=show-image">
        @endif
    </div>
</div>

<!-- Points Field -->
<div class="form-group col-sm-12">
    {!! Form::label('points', 'Points:') !!}
    {!! Form::text('points', null, ['class' => 'form-control']) !!}
</div>

<!-- Discount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('discount', 'Discount (%):') !!}
    {!! Form::text('discount', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('ranks.index') !!}" class="btn btn-default">Cancel</a>
</div>
