<table class="table table-responsive" id="passengers-table">
    <thead>
        <tr>
            <th>Fname</th>
        <th>Lname</th>
        <th>Email</th>
        <th>Password</th>
        <th>Phone</th>
        <th>Otp</th>
        <th>Exists User</th>
        <th>Payment Method</th>
        <th>Stripe Id</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($passengers as $passengers)
        <tr>
            <td>{!! $passengers->fname !!}</td>
            <td>{!! $passengers->lname !!}</td>
            <td>{!! $passengers->email !!}</td>
            <td>{!! $passengers->password !!}</td>
            <td>{!! $passengers->phone !!}</td>
            <td>{!! $passengers->otp !!}</td>
            <td>{!! $passengers->exists_user !!}</td>
            <td>{!! $passengers->payment_method !!}</td>
            <td>{!! $passengers->stripe_id !!}</td>
            <td>
                {!! Form::open(['route' => ['passengers.destroy', $passengers->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('passengers.show', [$passengers->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('passengers.edit', [$passengers->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>