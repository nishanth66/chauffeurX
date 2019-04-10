<table class="table table-responsive" id="notifications-table">
    <thead>
        <tr>
            <th>Type</th>
        <th>Title</th>
        <th>Image</th>
        <th>Message</th>
        <th>Read</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($notifications as $notification)
        <tr>
            <td>{!! $notification->type !!}</td>
            <td>{!! $notification->title !!}</td>
            <td>{!! $notification->image !!}</td>
            <td>{!! $notification->message !!}</td>
            <td>{!! $notification->read !!}</td>
            <td>
                {!! Form::open(['route' => ['notifications.destroy', $notification->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('notifications.show', [$notification->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('notifications.edit', [$notification->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>