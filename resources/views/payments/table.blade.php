<table class="table table-responsive" id="payments-table">
    <thead>
        <tr>
            <th>#</th>
            <th>City</th>
            <th>Name</th>
            <th>Cancellation</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($payments as $payment)
        <tr>
            <td>{!! $i !!}</td>
            <td>{!! $payment->city !!}</td>
            <td>{!! $payment->name !!}</td>
            <td>
                @if($payment->free == 1)
                    <button class="btn btn-success" type="button">Free</button>
                @else
                    <button class="btn btn-danger" type="button">Not Free</button>
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['paymentMethod.destroy', $payment->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
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