@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Coins for Frequest Ride
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        @include('flash::message')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    <form method="post" action="{{url('rideSaveCoins')}}">
                        {{csrf_field()}}
                        <div class="form-group col-sm-12">
                            <label>Number of Rides: </label>
                            <input type="text" name="rides" value="{{$rides}}" class="form-control">
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Coins: </label>
                            <input type="text" name="coins_ride" value="{{$coins}}" class="form-control">
                        </div>
                        <div class="form-group col-sm-12">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection