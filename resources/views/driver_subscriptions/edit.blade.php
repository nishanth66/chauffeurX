@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Driver Subscription
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($driverSubscription, ['route' => ['driverSubscriptions.update', $driverSubscription->id], 'method' => 'patch']) !!}

                        @include('driver_subscriptions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection