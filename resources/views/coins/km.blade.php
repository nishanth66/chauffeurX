@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Coins for Distance of Trip
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        @include('flash::message')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    <form method="post" action="{{url('kmSaveCoins')}}">
                        {{csrf_field()}}
                        <div class="form-group col-sm-12">
                            <label>Kilo-metres: </label>
                            <input type="text" name="kilo_meters" value="{{$km}}" class="form-control">
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Coins: </label>
                            <input type="text" name="coins_km" value="{{$coins}}" class="form-control">
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