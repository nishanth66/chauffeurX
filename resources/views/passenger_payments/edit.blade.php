@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Passenger Payment
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($passengerPayment, ['route' => ['passengerPayments.update', $passengerPayment->id], 'method' => 'patch']) !!}

                        @include('passenger_payments.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection