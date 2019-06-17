<table class="table table-responsive" id="driverPaymentHistories-table">
    <thead>
        <tr>
            <th>Driverid</th>
        <th>Amount</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($driverPaymentHistories as $driverPaymentHistory)
        <tr>
            <td>{!! $driverPaymentHistory->driverid !!}</td>
            <td>{!! $driverPaymentHistory->amount !!}</td>
            <td>
                {!! Form::open(['route' => ['driverPaymentHistories.destroy', $driverPaymentHistory->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('driverPaymentHistories.show', [$driverPaymentHistory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('driverPaymentHistories.edit', [$driverPaymentHistory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>