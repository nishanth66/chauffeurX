@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Driver Licence Details
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <center>
                        <table border="1" width="60%">
                            <thead>
                                <tr class="tr-height-40">
                                    <th width="50%">&ensp;Licence Number: </th>
                                    <th width="50%">&ensp;Licence expire: </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="tr-height-40">
                                    <td width="50%">&ensp;{{$licence->licence}}</td>
                                    <td width="50%">&ensp;{{$licence->licence_expire}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h2>Documents</h2>
                    </center>
                    <div class="form-group col-sm-6">
                        <label>Driving Licence: </label> <br/>
                        <a href="{{url('public/avatars').'/'.$licence->driving_licence}}" target="_blank"><img src="{{asset('public/avatars').'/'.$licence->driving_licence}}" class="show-doc"></a>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Car Registration: </label> <br/>
                        <a href="{{url('public/avatars').'/'.$licence->car_reg}}" target="_blank"><img src="{{asset('public/avatars').'/'.$licence->car_reg}}" class="show-doc"></a>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Car Insurance: </label> <br/>
                        <a href="{{url('public/avatars').'/'.$licence->car_insurance}}" target="_blank"><img src="{{asset('public/avatars').'/'.$licence->car_insurance}}" class="show-doc"></a>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Car Inspection: </label> <br/>
                        <a href="{{url('public/avatars').'/'.$licence->car_inspection}}" target="_blank"><img src="{{asset('public/avatars').'/'.$licence->car_inspection}}" class="show-doc"></a>
                    </div>
                    <a href="javascript:history.back()" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection