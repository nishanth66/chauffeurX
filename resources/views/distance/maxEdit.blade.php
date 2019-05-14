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
                    {!! Form::model($distance, ['route' => ['maximumDistance.update', $distance->id], 'method' => 'patch']) !!}

                    @include('distance.maxField')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection