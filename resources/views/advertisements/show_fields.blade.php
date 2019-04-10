<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $advertisement->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $advertisement->name !!}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $advertisement->description !!}</p>
</div>

<!-- Image Field -->
<div class="form-group">
    {!! Form::label('image', 'Image:') !!}
    <p>
        @if($advertisement->image != '' || !empty($advertisement->image))
            <img src="{{asset('public/avatars').'/'.$advertisement->image}}" class="show-image">
        @else
            <img src="{{asset('public/image/default.png')}}" class="show-image">
        @endif
    </p>
</div>

<!-- Place Field -->
<div class="form-group">
    {!! Form::label('place', 'Place:') !!}
    <p>{!! $advertisement->address !!}</p>
</div>

<!-- Lat Field -->
<div class="form-group">
    {!! Form::label('lat', 'Latitude:') !!}
    <p>{!! $advertisement->lat !!}</p>
</div>
<!-- Lat Field -->
<div class="form-group">
    {!! Form::label('lng', 'Longitude:') !!}
    <p>{!! $advertisement->lng !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $advertisement->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $advertisement->updated_at !!}</p>
</div>

