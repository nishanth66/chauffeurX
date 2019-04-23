@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Service Fee
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($serviceFee, ['route' => ['serviceFees.update', $serviceFee->id], 'method' => 'patch']) !!}

                        @include('service_fees.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection