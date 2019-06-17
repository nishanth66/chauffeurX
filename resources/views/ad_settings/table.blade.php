<table class="table table-responsive" id="adSettings-table">
    <thead>
        <tr>
            <th>City</th>
            <th>Cost per impression</th>
            <th>Cost per impression in a filtered category</th>
            <th>Maximum Distance</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($adSettings as $adSettings)
        <tr>
            <td>{!! $adSettings->city !!}</td>
            <td>{!! $adSettings->view_cost !!}</td>
            <td>{!! $adSettings->category_view_cost !!}</td>
            <td>{!! $adSettings->max_distance !!}</td>
            <td>
                {!! Form::open(['route' => ['adSettings.destroy', $adSettings->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('adSettings.edit', [$adSettings->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>