<table class="table table-responsive" id="pricePerMinutes-table">
    <thead>
        <tr>
            <th>Category</th>
            <th>Amount</th>
            <th>City</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pricePerMinutes as $pricePerMinute)
        <tr>
            <td>{!! $pricePerMinute->category !!}</td>
            <td>{!! $pricePerMinute->amount !!}</td>
            <td>{!! $pricePerMinute->city !!}</td>
            <td>
                {!! Form::open(['route' => ['pricePerMinutes.destroy', $pricePerMinute->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('pricePerMinutes.show', [$pricePerMinute->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('pricePerMinutes.edit', [$pricePerMinute->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>