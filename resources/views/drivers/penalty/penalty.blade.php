@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">
            Driver Penalty
        </h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('penalty.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body scrollable">
                <table class="table table-responsive" id="penalty-table">
                    <thead>
                    <tr>
                        <th>City</th>
                        <th>Penalty</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($penalties as $penalty)
                        <?php
                            $city = \App\Models\availableCities::whereId($penalty->city)->first();
                        ?>
                        <tr>
                            <td>{!! $city->city !!}</td>
                            <td>{!! $penalty->penalty !!}</td>
                            <td>
                                {!! Form::open(['route' => ['penalty.destroy', $penalty->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    <a href="{!! route('penalty.edit', [$penalty->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#penalty-table').DataTable( {
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
        // $(document).ready(function() {
        //     $('#paypalCredentials-table').DataTable();
        // } );
    </script>
@endsection