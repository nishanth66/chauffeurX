@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Passenger Api
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('passenger_apis.show_fields')
                    <a href="{!! route('passengerApis.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
