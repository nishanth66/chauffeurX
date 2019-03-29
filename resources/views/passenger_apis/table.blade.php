<table class="table table-responsive" id="passengerApis-table">
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Name</th>
            <th>Link</th>
            <th>Method</th>
            <th>Parameters</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $i =1;
    ?>
    @foreach($passengerApis as $passengerApi)
        <tr>
            <td>{{$i}}</td>
            <td>{!! $passengerApi->name !!}</td>
            <td>{!! $passengerApi->link !!}</td>
            <td>{!! $passengerApi->method !!}</td>
            <td>{!! $passengerApi->parameters !!}</td>
            <td>
                {!! Form::open(['route' => ['passengerApis.destroy', $passengerApi->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('passengerApis.show', [$passengerApi->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('passengerApis.edit', [$passengerApi->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
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