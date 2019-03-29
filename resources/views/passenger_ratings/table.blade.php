<table class="table table-responsive" id="passengerRatings-table">
    <thead>
        <tr>
            <th>Bookingid</th>
        <th>Userid</th>
        <th>Driverid</th>
        <th>Rating</th>
        <th>Comments</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($passengerRatings as $passengerRating)
        <tr>
            <td>{!! $passengerRating->bookingid !!}</td>
            <td>{!! $passengerRating->userid !!}</td>
            <td>{!! $passengerRating->driverid !!}</td>
            <td>{!! $passengerRating->rating !!}</td>
            <td>{!! $passengerRating->comments !!}</td>
            <td>
                {!! Form::open(['route' => ['passengerRatings.destroy', $passengerRating->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('passengerRatings.show', [$passengerRating->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('passengerRatings.edit', [$passengerRating->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>