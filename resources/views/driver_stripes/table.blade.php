<table class="table table-responsive" id="driverStripes-table">
    <thead>
        <tr>
            <th>Userid</th>
        <th>Cardno</th>
        <th>Fingerprint</th>
        <th>Status</th>
        <th>Token</th>
        <th>Brand</th>
        <th>Customerid</th>
        <th>Digits</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($driverStripes as $driverStripe)
        <tr>
            <td>{!! $driverStripe->userid !!}</td>
            <td>{!! $driverStripe->cardNo !!}</td>
            <td>{!! $driverStripe->fingerprint !!}</td>
            <td>{!! $driverStripe->status !!}</td>
            <td>{!! $driverStripe->token !!}</td>
            <td>{!! $driverStripe->brand !!}</td>
            <td>{!! $driverStripe->customerId !!}</td>
            <td>{!! $driverStripe->digits !!}</td>
            <td>
                {!! Form::open(['route' => ['driverStripes.destroy', $driverStripe->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('driverStripes.show', [$driverStripe->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('driverStripes.edit', [$driverStripe->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>