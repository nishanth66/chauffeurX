<table class="table table-responsive" id="filters-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($filters as $filter)
        <tr>
            <td>{!! $filter->name !!}</td>
            <td>
                {!! Form::open(['route' => ['filters.destroy', $filter->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('filters.show', [$filter->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('filters.edit', [$filter->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>