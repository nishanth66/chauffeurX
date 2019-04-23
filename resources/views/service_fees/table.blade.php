<table class="table table-responsive" id="serviceFees-table">
    <thead>
        <tr>
            <th>City</th>
        <th>Category</th>
        <th>Amount</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($serviceFees as $serviceFee)
        <tr>
            <td>{!! $serviceFee->city !!}</td>
            <td>{!! $serviceFee->category !!}</td>
            <td>{!! $serviceFee->amount !!}</td>
            <td>
                {!! Form::open(['route' => ['serviceFees.destroy', $serviceFee->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('serviceFees.show', [$serviceFee->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('serviceFees.edit', [$serviceFee->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>