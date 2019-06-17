<table class="table table-responsive" id="driverSubscriptions-table">
    <thead>
        <tr>
            <th>City</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($driverSubscriptions as $driverSubscription)
        <?php
                $category = \App\Models\categories::whereId($driverSubscription->category)->first()
        ?>
        <tr>
            <td>{!! $driverSubscription->city !!}</td>
            <td>{!! $category->name !!}</td>
            <td>{!! $driverSubscription->amount !!}</td>
            <td>
                {!! Form::open(['route' => ['driverSubscriptions.destroy', $driverSubscription->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('driverSubscriptions.show', [$driverSubscription->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('driverSubscriptions.edit', [$driverSubscription->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>