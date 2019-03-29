<table class="table table-responsive" id="driverTips-table">
    <thead>
        <tr>
            <th>Booking Id</th>
        <th>Userid</th>
        <th>Driverid</th>
        <th>Amount</th>
        <th>Comments</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($driverTips as $driverTips)
        <tr>
            <td>{!! $driverTips->booking_id !!}</td>
            <td>{!! $driverTips->userid !!}</td>
            <td>{!! $driverTips->driverid !!}</td>
            <td>{!! $driverTips->amount !!}</td>
            <td>{!! $driverTips->comments !!}</td>
            <td>
                {!! Form::open(['route' => ['driverTips.destroy', $driverTips->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('driverTips.show', [$driverTips->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('driverTips.edit', [$driverTips->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>