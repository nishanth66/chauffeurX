<table class="table table-responsive" id="pricePerMinutes-table">
    <thead>
        <tr>
            <th>City</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pricePerMinutes as $pricePerMinute)
    <?php
    $city = \App\Models\availableCities::whereId($pricePerMinute->city)->first();
    $category = \App\Models\categories::whereId($pricePerMinute->category)->first();
    ?>
    <tr>
        <td>{!! $city->city !!}</td>
        <td>{!! $category->name !!}</td>
            <td>{!! $pricePerMinute->amount !!}</td>
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