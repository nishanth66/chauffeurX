@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Driver Stripe
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($driverStripe, ['route' => ['driverStripes.update', $driverStripe->id], 'method' => 'patch']) !!}

                        @include('driver_stripes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection