<table class="table table-responsive" id="ranks-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Image</th>
        <th>Points</th>
        <th>Discount</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($ranks as $rank)
        <tr>
            <td>{!! $rank->name !!}</td>
            <td>{!! $rank->image !!}</td>
            <td>{!! $rank->points !!}</td>
            <td>{!! $rank->discount !!}</td>
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