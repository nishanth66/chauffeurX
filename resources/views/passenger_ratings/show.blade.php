@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Passenger Rating
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('passenger_ratings.show_fields')
                    <a href="{!! route('passengerRatings.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
