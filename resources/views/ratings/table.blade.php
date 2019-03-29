<table class="table table-responsive" id="ratings-table">
    <thead>
        <tr>
            <th>Userid</th>
        <th>Booking Id</th>
        <th>Driverid</th>
        <th>Rating</th>
        <th>Comments</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($ratings as $rating)
        <tr>
            <td>{!! $rating->userid !!}</td>
            <td>{!! $rating->booking_id !!}</td>
            <td>{!! $rating->driverid !!}</td>
            <td>{!! $rating->rating !!}</td>
            <td>{!! $rating->comments !!}</td>
            <td>
                {!! Form::open(['route' => ['ratings.destroy', $rating->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('ratings.show', [$rating->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('ratings.edit', [$rating->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>