@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Advertisement Categories
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($adCategory, ['route' => ['adCategories.update', $adCategory->id], 'method' => 'patch']) !!}

                        @include('ad_categories.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection