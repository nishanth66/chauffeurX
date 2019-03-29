<table class="table table-responsive" id="bookings-table">
    <thead>
        <tr>
            <th>Userid</th>
        <th>Phone</th>
        <th>Completed</th>
        <th>Source</th>
        <th>Destination</th>
        <th>Price</th>
        <th>Distance</th>
        <th>Trip Date</th>
        <th>Trip Time</th>
        <th>Source Description</th>
        <th>Destination Description</th>
        <th>Alternate Phone</th>
        <th>Statu</th>
        <th>Image</th>
        <th>Payment</th>
        <th>Paid</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($bookings as $booking)
        <tr>
            <td>{!! $booking->userid !!}</td>
            <td>{!! $booking->phone !!}</td>
            <td>{!! $booking->completed !!}</td>
            <td>{!! $booking->source !!}</td>
            <td>{!! $booking->destination !!}</td>
            <td>{!! $booking->price !!}</td>
            <td>{!! $booking->distance !!}</td>
            <td>{!! $booking->trip_date !!}</td>
            <td>{!! $booking->trip_time !!}</td>
            <td>{!! $booking->source_description !!}</td>
            <td>{!! $booking->destination_description !!}</td>
            <td>{!! $booking->alternate_phone !!}</td>
            <td>{!! $booking->statu !!}</td>
            <td>{!! $booking->image !!}</td>
            <td>{!! $booking->payment !!}</td>
            <td>{!! $booking->paid !!}</td>
            <td>
                {!! Form::open(['route' => ['bookings.destroy', $booking->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('bookings.show', [$booking->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('bookings.edit', [$booking->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>