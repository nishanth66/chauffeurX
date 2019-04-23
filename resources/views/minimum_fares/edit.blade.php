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
                   {!! Form::model($minimumFare, ['route' => ['minimumFares.update', $minimumFare->id], 'method' => 'patch']) !!}

                        @include('minimum_fares.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection