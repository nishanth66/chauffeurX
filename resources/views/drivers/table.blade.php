<table class="table table-responsive" id="drivers-table">
    <thead>
        <tr>
            <th>Fname</th>
        <th>Lname</th>
        <th>Image</th>
        <th>Phone</th>
        <th>Car No</th>
        <th>Licence</th>
        <th>Isavailable</th>
        <th>Status</th>
        <th>Email</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($drivers as $driver)
        <tr>
            <td>{!! $driver->fname !!}</td>
            <td>{!! $driver->lname !!}</td>
            <td>{!! $driver->image !!}</td>
            <td>{!! $driver->phone !!}</td>
            <td>{!! $driver->car_no !!}</td>
            <td>{!! $driver->licence !!}</td>
            <td>{!! $driver->isAvailable !!}</td>
            <td>{!! $driver->status !!}</td>
            <td>{!! $driver->email !!}</td>
            <td>
                {!! Form::open(['route' => ['drivers.destroy', $driver->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('drivers.show', [$driver->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('drivers.edit', [$driver->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>