<table class="table table-responsive" id="driverApis-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Link</th>
        <th>Method</th>
        <th>Parameters</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($driverApis as $driverApi)
        <tr>
            <td>{!! $driverApi->name !!}</td>
            <td>{!! $driverApi->link !!}</td>
            <td>{!! $driverApi->method !!}</td>
            <td>{!! $driverApi->parameters !!}</td>
            <td>
                {!! Form::open(['route' => ['driverApis.destroy', $driverApi->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('driverApis.show', [$driverApi->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('driverApis.edit', [$driverApi->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>