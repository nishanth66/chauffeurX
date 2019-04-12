@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Coins for Sharing the app on Social Media
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        @include('flash::message')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    <form method="post" action="{{url('shareSaveCoins')}}">
                        @include('coins.fields')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
