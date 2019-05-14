@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Coins Settings
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        @include('flash::message')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    <form method="post" action="{{url('coins/setting')}}">
                        @include('coins.allFields')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
