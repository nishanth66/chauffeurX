@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Minimum Fare
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'minimumFares.store']) !!}

                        @include('minimum_fares.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
