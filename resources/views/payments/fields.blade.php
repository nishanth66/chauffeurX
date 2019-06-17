@section('css')
    <style>
        #makeFree, #notFree
        {
            display: none;
        }
    </style>
@endsection
<!-- Booking Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('city', 'City:') !!}
    <select name="city" class="form-control">
        <option value="" selected disabled>Select a City</option>
        @foreach($cities as $city)
            <option value="{{$city->city}}" <?php if(isset($payments) && $payments->city == $city->city) { echo "selected"; } ?>>{{$city->city}}</option>
        @endforeach
    </select>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">
@if(isset($payments))
    @if($payments->free == 0)
        <button type="button" class="btn btn-success" id="makeFree" style="display: block">Cancellation is free</button>
        <button type="button" class="btn btn-danger" id="notFree">Cancellation is not free</button>
    @else
        <button type="button" class="btn btn-danger" id="notFree" style="display: block">Cancellation is not free</button>
        <button type="button" class="btn btn-success" id="makeFree">Cancellation is free</button>
    @endif
@else
    <button type="button" class="btn btn-success" id="makeFree" style="display: block">Cancellation is free</button>
    <button type="button" class="btn btn-danger" id="notFree">Cancellation is not free</button>
@endif
</div>
<!--<div class="form-group col-sm-12">-->
    {!! Form::hidden('free', null, ['class' => 'form-control','id'=> 'free']) !!}
<!--</div>-->

<!-- Userid Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','rows'=>5,'cols'=>40]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('paymentMethod.index') !!}" class="btn btn-default">Cancel</a>
</div>
@section('scripts')
    <script>
        $('#makeFree').click(function () {
            $('#free').val(1);
            $('#makeFree').hide();
            $('#notFree').show();
        });
        $('#notFree').click(function () {
            $('#free').val(0);
            $('#makeFree').show();
            $('#notFree').hide();
        })
    </script>
@endsection