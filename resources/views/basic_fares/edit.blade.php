@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Basic Fare
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($basicFare, ['route' => ['basicFares.update', $basicFare->id], 'method' => 'patch']) !!}

                        @include('basic_fares.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection