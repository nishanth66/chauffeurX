<table class="table table-responsive" id="cencellations-table">
    <thead>
        <tr>
            <th>Amount</th>
        <th>Terms</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($cencellations as $cencellation)
        <tr>
            <td>{!! $cencellation->amount !!}</td>
            <td>{!! $cencellation->terms !!}</td>
            <td>
                {!! Form::open(['route' => ['cencellations.destroy', $cencellation->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('cencellations.show', [$cencellation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('cencellations.edit', [$cencellation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>