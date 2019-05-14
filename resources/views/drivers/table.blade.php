<table class="table table-responsive" id="drivers-table">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Licence</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($drivers as $driver)
        <tr>
            <td>{!! $driver->first_name !!}</td>
            <td>{!! $driver->middle_name !!}</td>
            <td>{!! $driver->last_name !!}</td>
            <td>{!! $driver->email !!}</td>
            <td>{!! $driver->phone !!}</td>
            <td>
                <a href="{{url('driver/licence').'/'.$driver->id}}" class="btn btn-info">Details</a>
            </td>
            <td>
                @if($driver->status == 0)
                    <a href="{{url('driver/accept').'/'.$driver->id}}" class="btn btn-success btn-flat btn-xs" title="Accept the Driver" onclick='return confirm("Are you sure?")'><i class="fa fa-check" aria-hidden="true"></i></a>
                    <a href="{{url('driver/reject').'/'.$driver->id}}" class="btn btn-danger btn-flat btn-xs" title="Reject the Driver" onclick='return confirm("Are you sure?")'><i class="fa fa-times" aria-hidden="true"></i></a>
                @elseif($driver->status == 2)
                    <a href="{{url('driver/accept').'/'.$driver->id}}" class="btn btn-success btn-flat btn-xs" title="Accept the Driver" onclick='return confirm("Are you sure?")'><i class="fa fa-check" aria-hidden="true"></i></a>
                @else
                    <a href="{{url('driver/reject').'/'.$driver->id}}" class="btn btn-danger btn-flat btn-xs" title="Reject the Driver" onclick='return confirm("Are you sure?")'><i class="fa fa-times" aria-hidden="true"></i></a>
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['drivers.destroy', $driver->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('drivers.show', [$driver->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>