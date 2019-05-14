<table class="table table-responsive" id="cencellations-table">
    <thead>
        <tr>
            <th>City</th>
            <th>Amount</th>
            <th>Maximum Time to Cancel the Ride (in Mins)</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($cencellations as $cencellation)
        <tr>
            <td>{!! $cencellation->city !!}</td>
            <td>{!! $cencellation->amount !!}</td>
            <td>{!! $cencellation->max_time !!}</td>
            <td>
                {!! Form::open(['route' => ['cancellations.destroy', $cencellation->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('cancellations.edit', [$cencellation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>