<table class="table table-responsive" id="userCoupons-table">
    <thead>
        <tr>
            <th>Userid</th>
            <th>Code</th>
            <th>Status</th>
            <th>Discount</th>
            <th>Expire</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($userCoupons as $userCoupons)
        <tr>
            <td>{!! $userCoupons->userid !!}</td>
            <td>{!! $userCoupons->code !!}</td>
            <td>{!! $userCoupons->status !!}</td>
            <td>{!! $userCoupons->discount !!}%</td>
            <td>{!! date('d/M/Y',$userCoupons->expire) !!}</td>
            <td>
                {!! Form::open(['route' => ['userCoupons.destroy', $userCoupons->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('userCoupons.show', [$userCoupons->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('userCoupons.edit', [$userCoupons->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>