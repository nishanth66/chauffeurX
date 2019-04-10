<!-- Userid Field -->
<div class="form-group col-sm-12">
    {!! Form::label('userid', 'User:') !!}
    <select name="userid" class="form-control">
        <option value="" selected disabled>Select a User</option>
        @foreach($users as $user)
            <option value="{{$user->id}}" <?php if (isset($userCoupons) && $userCoupons->userid == $user->id){ echo "selected"; } ?> >{{$user->fname.' '.$user->lname}}</option>
        @endforeach
    </select>
</div>

<!-- Code Field -->
<div class="form-group col-sm-12">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Discount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('discount', 'Discount (%):') !!}
    {!! Form::text('discount', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('userCoupons.index') !!}" class="btn btn-default">Cancel</a>
</div>

