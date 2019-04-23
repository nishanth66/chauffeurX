<table class="table table-responsive" id="drivers-table">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Licence</th>
            @if(isset($code) && $code == 0)
                <th>Status</th>
            @endif
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
            @if(isset($code) && $code == 0)
                <td>
                    @if($driver->status == 0)
                    <a href="{{url('driver/accept').'/'.$driver->id}}" class="btn btn-success btn-flat btn-xs" title="Accept the Driver" onclick='return confirm("Are you sure?")'><i class="fa fa-check" aria-hidden="true"></i></a>
                    <a href="{{url('driver/reject').'/'.$driver->id}}" class="btn btn-danger btn-flat btn-xs" title="Reject the Driver" onclick='return confirm("Are you sure?")'><i class="fa fa-times" aria-hidden="true"></i></a>
                    @elseif($driver->status == 2)
                        <button class="btn btn-danger btn-flat">Rejected</button>
                    @endif
                </td>
            @endif
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