@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User Coupons
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($userCoupons, ['route' => ['userCoupons.update', $userCoupons->id], 'method' => 'patch']) !!}

                        @include('user_coupons.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection