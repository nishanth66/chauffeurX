<table class="table table-responsive" id="favDrivers-table">
    <thead>
        <tr>
            <th>Userid</th>
        <th>Driverid</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($favDrivers as $favDriver)
        <tr>
            <td>{!! $favDriver->userid !!}</td>
            <td>{!! $favDriver->driverid !!}</td>
            <td>
                {!! Form::open(['route' => ['favDrivers.destroy', $favDriver->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('favDrivers.show', [$favDriver->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('favDrivers.edit', [$favDriver->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>