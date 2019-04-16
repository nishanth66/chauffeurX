<table class="table table-responsive" id="musicPreferences-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($musicPreferences as $musicPreference)
        <tr>
            <td>{!! $musicPreference->name !!}</td>
            <td>
                {!! Form::open(['route' => ['musicPreferences.destroy', $musicPreference->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('musicPreferences.show', [$musicPreference->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('musicPreferences.edit', [$musicPreference->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>