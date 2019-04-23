<table class="table table-responsive" id="basicFares-table">
    <thead>
        <tr>
            <th>City</th>
        <th>Category</th>
        <th>Amount</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($basicFares as $basicFare)
        <tr>
            <td>{!! $basicFare->city !!}</td>
            <td>{!! $basicFare->category !!}</td>
            <td>{!! $basicFare->amount !!}</td>
            <td>
                {!! Form::open(['route' => ['basicFares.destroy', $basicFare->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('basicFares.show', [$basicFare->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('basicFares.edit', [$basicFare->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>