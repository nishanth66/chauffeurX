@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Music Preference
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($musicPreference, ['route' => ['musicPreferences.update', $musicPreference->id], 'method' => 'patch']) !!}

                        @include('music_preferences.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection