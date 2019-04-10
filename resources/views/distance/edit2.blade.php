@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Maximum Distance
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <form method="post" action="{{url('ad-distance/save')}}">
                        {{csrf_field()}}
                        <div class="form-group col-sm-12">
                            {!! Form::label('ads', 'Distance to display Ads near the Destination (in Kms):') !!}
                            {!! Form::text('ads', $distance, ['class' => 'form-control','placeholer' => 'Distance to display Ads near the Destination (in Kms)','required']) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('driverDistance.index') !!}" class="btn btn-default">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection