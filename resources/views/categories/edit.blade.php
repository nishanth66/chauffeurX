@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Categories
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($categories, ['route' => ['categories.update', $categories->id], 'method' => 'patch','files'=>true]) !!}

                        @include('categories.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection