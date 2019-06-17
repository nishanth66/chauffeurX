@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Advertisement Settings</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('adSettings.create') !!}">Add New</a>
        </h1> <br/> <br/>
        @if ($message = Session::get('adSettings'))
            <?php
            $sessionCity = $message;
            ?>

        @endif

        <div class="form-group col-sm-4 pull-right">
            <select class="form-control" id="city" onchange="changeCity(this.value)">
                <option value="" selected disabled>Select a City</option>
                <option value="all" @if(isset($sessionCity) && $sessionCity == 'all') selected @endif>All Cities</option>
                @foreach($cities as $city)
                    <option value="{{$city->city}}" @if(isset($sessionCity) && $sessionCity == $city->city) selected @endif>{{$city->city}}</option>
                @endforeach
            </select>
        </div>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('ad_settings.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#adSettings-table').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, ':visible' ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                ]
            } );
        } );
    </script>
    <script>
        function changeCity(city)
        {
            $.ajax({
                url: "{{url('changeAdCity')}}"+"/"+city,
                success: function(result)
                {
                    window.location.reload();
                }
            });
        }
    </script>
@endsection

