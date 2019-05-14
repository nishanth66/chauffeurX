@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Driver Payment
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($driverPayment, ['route' => ['driverPayments.update', $driverPayment->id], 'method' => 'patch']) !!}

                        @include('driver_payments.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection