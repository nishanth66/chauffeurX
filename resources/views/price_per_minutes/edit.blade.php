@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Price Per Minute
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($pricePerMinute, ['route' => ['pricePerMinutes.update', $pricePerMinute->id], 'method' => 'patch']) !!}

                        @include('price_per_minutes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection