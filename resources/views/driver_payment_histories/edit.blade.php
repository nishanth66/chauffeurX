@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Driver Payment History
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($driverPaymentHistory, ['route' => ['driverPaymentHistories.update', $driverPaymentHistory->id], 'method' => 'patch']) !!}

                        @include('driver_payment_histories.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection