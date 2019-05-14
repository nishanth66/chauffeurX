@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">
            @if(isset($code) && $code == 0)
                Pending Drivers
            @elseif(isset($code) && $code == 2)
                Rejected Drivers
            @else
                Accepted Drivers
            @endif
        </h1>
        {{--<h1 class="">--}}
            <div class="form-group col-sm-4 pull-right">
                @if ($message = Session::get(''.$code.''))
                    <?php
                        $msg = explode('-',$message);
                        $SessionCode = $msg[1];
                        if ($SessionCode == $code)
                            {
                                $SessionCity = $msg[0];
                            }
                    ?>

                @endif
                <select class="form-control" id="city" onchange="@if(isset($code)) changeCity(this.value,'{{$code}}'); @else changeCity(this.value,1); @endif">
                    <option value="" selected disabled>Select a City</option>
                    <option value="all" @if(isset($SessionCity) && $SessionCity == 'all') selected @endif>All cities</option>
                    @foreach($cities as $city)
                        <option value="{{$city->city}}" @if(isset($SessionCity) && $SessionCity == $city->city) selected @endif>{{$city->city}}</option>
                    @endforeach
                </select>

            </div>
        {{--</h1>--}}
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body scrollable" id="scrollable">
                    @include('drivers.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#drivers-table').DataTable( {
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
       
        function changeCity(city,val) {
           $.ajax({
               url: "{{url('changeCity')}}"+"/"+city+"/"+val,
               success: function(result)
               {
                   if (result['code'] == 200)
                   {
                       $('#drivers-table').html(result['data']);
                   }
                   else
                   {
                       window.location.reload();
                   }
               }
           });
        }
    </script>
    {{--@if(isset($SessionCity))--}}
        {{--<script>--}}
            {{--changeCity('{{$SessionCity}}','{{$code}}')--}}
        {{--</script>--}}
    {{--@endif--}}
@endsection