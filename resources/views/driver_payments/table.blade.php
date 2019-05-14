<table class="table table-responsive" id="driverPayments-table">
    <thead>
        <tr>
            <th>Driverid</th>
        <th>Amount</th>
        <th>Cardid</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($driverPayments as $driverPayment)
        <tr>
            <td>{!! $driverPayment->driverid !!}</td>
            <td>{!! $driverPayment->amount !!}</td>
            <td>{!! $driverPayment->cardid !!}</td>
            <td>
                {!! Form::open(['route' => ['driverPayments.destroy', $driverPayment->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('driverPayments.show', [$driverPayment->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('driverPayments.edit', [$driverPayment->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>