@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Fav Driver
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($favDriver, ['route' => ['favDrivers.update', $favDriver->id], 'method' => 'patch']) !!}

                        @include('fav_drivers.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection