@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Cancellation
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($cencellation, ['route' => ['cancellations.update', $cencellation->id], 'method' => 'patch']) !!}

                        @include('cencellations.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection