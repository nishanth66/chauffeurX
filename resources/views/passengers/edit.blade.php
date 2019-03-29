@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Passengers
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($passengers, ['route' => ['passengers.update', $passengers->id], 'method' => 'patch']) !!}

                        @include('passengers.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection