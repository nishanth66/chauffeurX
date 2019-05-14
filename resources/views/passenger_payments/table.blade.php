<table class="table table-responsive" id="passengerPayments-table">
    <thead>
        <tr>
            <th>Userid</th>
        <th>Bookingid</th>
        <th>Amount</th>
        <th>Cardid</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($passengerPayments as $passengerPayment)
        <tr>
            <td>{!! $passengerPayment->userid !!}</td>
            <td>{!! $passengerPayment->bookingid !!}</td>
            <td>{!! $passengerPayment->amount !!}</td>
            <td>{!! $passengerPayment->cardid !!}</td>
            <td>
                {!! Form::open(['route' => ['passengerPayments.destroy', $passengerPayment->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('passengerPayments.show', [$passengerPayment->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('passengerPayments.edit', [$passengerPayment->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>