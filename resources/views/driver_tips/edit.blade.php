@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Driver Tips
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($driverTips, ['route' => ['driverTips.update', $driverTips->id], 'method' => 'patch']) !!}

                        @include('driver_tips.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection