<table class="table table-responsive" id="adCategories-table">
    <thead>
        <tr>
            <th>City</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($adCategories as $adCategory)
        <tr>
            <td>{!! $adCategory->city !!}</td>
            <td>{!! $adCategory->name !!}</td>
            <td>
                {!! Form::open(['route' => ['adCategories.destroy', $adCategory->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('adCategories.edit', [$adCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>