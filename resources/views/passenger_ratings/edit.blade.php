@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Passenger Rating
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($passengerRating, ['route' => ['passengerRatings.update', $passengerRating->id], 'method' => 'patch']) !!}

                        @include('passenger_ratings.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection