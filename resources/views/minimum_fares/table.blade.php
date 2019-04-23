<table class="table table-responsive" id="minimumFares-table">
    <thead>
        <tr>
            <th>City</th>
        <th>Category</th>
        <th>Amount</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($minimumFares as $minimumFare)
        <tr>
            <td>{!! $minimumFare->city !!}</td>
            <td>{!! $minimumFare->category !!}</td>
            <td>{!! $minimumFare->amount !!}</td>
            <td>
                {!! Form::open(['route' => ['minimumFares.destroy', $minimumFare->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('minimumFares.show', [$minimumFare->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('minimumFares.edit', [$minimumFare->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>