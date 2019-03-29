<table class="table table-responsive" id="invitedFriends-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Phone</th>
        <th>Date</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($invitedFriends as $invitedFriends)
        <tr>
            <td>{!! $invitedFriends->name !!}</td>
            <td>{!! $invitedFriends->phone !!}</td>
            <td>{!! $invitedFriends->date !!}</td>
            <td>
                {!! Form::open(['route' => ['invitedFriends.destroy', $invitedFriends->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('invitedFriends.show', [$invitedFriends->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('invitedFriends.edit', [$invitedFriends->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>