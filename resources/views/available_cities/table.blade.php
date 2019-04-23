<table class="table table-responsive" id="availableCities-table">
    <thead>
        <tr>
            <th>City</th>
            <th>Start Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($availableCities as $availableCities)
        <tr>
            <td>{!! $availableCities->city !!}</td>
            <td>{!! $availableCities->start_date !!}</td>
            <td>
                {!! Form::open(['route' => ['availableCities.destroy', $availableCities->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('availableCities.show', [$availableCities->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('availableCities.edit', [$availableCities->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>