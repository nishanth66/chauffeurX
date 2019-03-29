@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Invited Friends
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($invitedFriends, ['route' => ['invitedFriends.update', $invitedFriends->id], 'method' => 'patch']) !!}

                        @include('invited_friends.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection