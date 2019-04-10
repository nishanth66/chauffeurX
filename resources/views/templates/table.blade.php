<table class="table table-responsive" id="templates-table">
    <thead>
        <tr>
            <th>Type</th>
            <th>Title</th>
            <th>Image</th>
            <th>Message</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($templates as $template)
        <tr>
            <td>{!! $template->type !!}</td>
            <td>{!! $template->title !!}</td>
            <td>
                @if(isset($template->image) && ($template->image != '' || !empty($template->image)))
                    <img src="{{asset('public/avatars').'/'.$template->image}}" class="show-image">
                @else
                    <img src="{{asset('public/image/default.png')}}" class="show-image">
                @endif
            </td>
            <td>{!! $template->message !!}</td>
            <td>
                {!! Form::open(['route' => ['templates.destroy', $template->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('templates.show', [$template->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('templates.edit', [$template->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>