<table class="table table-responsive" id="ranks-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Image</th>
        <th>Points</th>
        <th>Discount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($ranks as $rank)
        <tr>
            <td>{!! $rank->name !!}</td>
            <td>
                @if(!empty($rank->image))
                    <img src="{{asset('public/avatars').'/'.$rank->image}}" class="show-image">
                @else
                    <img src="{{asset('public/image/default.png')}}" class="show-image">
                @endif
            </td>
            <td>{!! $rank->points !!}</td>
            <td>{!! $rank->discount !!}%</td>
            <td>
                {!! Form::open(['route' => ['ranks.destroy', $rank->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('ranks.show', [$rank->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('ranks.edit', [$rank->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>