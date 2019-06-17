@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Advertisement Settings
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($adSettings, ['route' => ['adSettings.update', $adSettings->id], 'method' => 'patch']) !!}

                        @include('ad_settings.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection