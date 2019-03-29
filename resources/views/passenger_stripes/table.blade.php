<table class="table table-responsive" id="passengerStripes-table">
    <thead>
        <tr>
            <th>Userid</th>
        <th>Cardno</th>
        <th>Fingerprint</th>
        <th>Token</th>
        <th>Brand</th>
        <th>Customerid</th>
        <th>Digits</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($passengerStripes as $passengerStripe)
        <tr>
            <td>{!! $passengerStripe->userid !!}</td>
            <td>{!! $passengerStripe->cardNo !!}</td>
            <td>{!! $passengerStripe->fingerprint !!}</td>
            <td>{!! $passengerStripe->token !!}</td>
            <td>{!! $passengerStripe->brand !!}</td>
            <td>{!! $passengerStripe->customerId !!}</td>
            <td>{!! $passengerStripe->digits !!}</td>
            <td>
                {!! Form::open(['route' => ['passengerStripes.destroy', $passengerStripe->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('passengerStripes.show', [$passengerStripe->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('passengerStripes.edit', [$passengerStripe->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>