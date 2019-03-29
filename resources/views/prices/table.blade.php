<table class="table table-responsive" id="prices-table">
    <thead>
        <tr>
            <th>Category</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($prices as $price)
        <?php
            $category = \App\Models\categories::whereId($price->category)->first();
        ?>
        <tr>
            <td>{!! $category->name !!}</td>
            <td>{!! $price->amount !!}</td>
            <td>
                {!! Form::open(['route' => ['prices.destroy', $price->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('prices.show', [$price->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('prices.edit', [$price->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>