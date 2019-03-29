@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Passenger Api
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'passengerApis.store']) !!}

                        @include('passenger_apis.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
