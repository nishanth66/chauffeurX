<table class="table table-responsive" id="advertisements-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Address</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($advertisements as $advertisement)
        <tr>
            <td>{!! $advertisement->name !!}</td>
            <td>{!! $advertisement->description !!}</td>
            <td>
                @if(isset($advertisement->image) && $advertisement->image != '' || !empty($advertisement->image))
                    <img src="{{asset('public/avatars').'/'.$advertisement->image }}" class="show-image">
                @else
                    <img src="{{asset('public/image/default.png')}}" class="show-image">
                @endif
            </td>
            <td>{!! $advertisement->address !!}</td>
            <td>{!! $advertisement->lat !!}</td>
            <td>{!! $advertisement->lng !!}</td>
            <td>
                {!! Form::open(['route' => ['advertisements.destroy', $advertisement->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('advertisements.show', [$advertisement->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('advertisements.edit', [$advertisement->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>