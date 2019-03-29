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
                   {!! Form::model($passengerApi, ['route' => ['passengerApis.update', $passengerApi->id], 'method' => 'patch']) !!}

                        @include('passenger_apis.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection