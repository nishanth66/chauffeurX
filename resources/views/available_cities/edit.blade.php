@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Available Cities
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($availableCities, ['route' => ['availableCities.update', $availableCities->id], 'method' => 'patch']) !!}

                        @include('available_cities.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection