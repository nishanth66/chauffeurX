@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Driver
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($penalty, ['route' => ['penalty.update', $penalty->id], 'method' => 'patch']) !!}

                    @include('drivers.penalty.penaltyFields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection