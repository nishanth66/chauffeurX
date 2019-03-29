<table class="table table-responsive" id="payments-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($payments as $payment)
        <tr>
            <td>{!! $i !!}</td>
            <td>{!! $payment->name !!}</td>
            <td>{!! $payment->description !!}</td>
            <td>
                {!! Form::open(['route' => ['paymentMethod.destroy', $payment->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('paymentMethod.show', [$payment->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('paymentMethod.edit', [$payment->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        <?php
            $i++;
        ?>
    @endforeach
    </tbody>
</table>