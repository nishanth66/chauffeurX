<div class="loader" id="loader-2">
    <span></span>
    <span></span>
    <span></span>
</div>
@extends('layouts.app')
@section('css')
    <style>
        .alert
        {
            display: none !important;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Driver Subscriptions</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('driverSubscriptions.create') !!}">Add New</a>
        </h1> <br/> <br/>
        <?php
            if (\Illuminate\Support\Facades\Cookie::get('citySubscription'))
            {
               $cookie =  \Illuminate\Support\Facades\Cookie::get('citySubscription');
            }
            else
            {
                $cookie = 'all';
            }
        ?>
        <div class="form-group col-sm-4 pull-right">
            <select class="form-control" id="city" onchange="changeCity(this.value)">
                <option value="" selected disabled>Select a City</option>
                <option value="all" @if(isset($cookie) && $cookie == 'all') selected @endif>All Cities</option>
                @foreach($cities as $city)
                    <option value="{{$city->city}}" @if(isset($cookie) && $cookie == $city->city) selected @endif>{{$city->city}}</option>
                @endforeach
            </select>
        </div>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('driver_subscriptions.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        $(document).ready(function() {
            $(".alert").slideUp(0);
            $('#driverSubscriptions-table').DataTable( {
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
            if (($('.alert-success').contents().length  != 0))
            {
                $.toast({
                    heading: 'Success',
                    text: $('.alert-success').text(),
                    icon: 'success',
                    hideAfter: 5000,
                    showHideTransition: 'slide',
                    loader: false
                })

            }
            if (($('.alert-danger').contents().length  != 0))
            {
                $.toast({
                    heading: 'Failed',
                    text: $('.alert-danger').text(),
                    icon: 'error',
                    hideAfter: 5000,
                    showHideTransition: 'slide',
                    loader: false
                })

            }
        } );
    </script>
    <script>
        function changeCity(city)
        {
            $('.loader').show();
            $.ajax({
                url: "{{url('changeSubscriptionCity')}}"+"/"+city,
                success: function(result)
                {
                    window.location.reload();
                    $('.loader').hide();
                },
                error: function (error) {
                    $('.loader').hide();
                    $.toast({
                        heading: 'Failed',
                        text: "Could't change the city",
                        icon: 'error',
                        hideAfter: 5000,
                        showHideTransition: 'slide',
                        loader: false
                    })
                }
            });
        }
    </script>
@endsection

