<table class="table table-responsive" id="categories-table">
    <thead>
        <tr>
            <th>City</th>
            <th>Name</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($categories as $categories)
        <tr>
            <td>{!! $categories->city !!}</td>
            <td>{!! $categories->name !!}</td>
            <td>
                @if(isset($categories->image) && $categories->image != '' || $categories->image != null)
                    <img src="{{asset('public/avatars').'/'.$categories->image}}" class="show-image">
                @else
                    <img src="{{asset('public/image/default.png')}}" class="show-image">
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['categories.destroy', $categories->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('categories.edit', [$categories->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>