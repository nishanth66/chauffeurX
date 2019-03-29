<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;

class maximumDistanceController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
        if (DB::table('maximum_distance')->exists())
        {
            $distance = DB::table('maximum_distance')->first();
            return view('distance.edit',compact('distance'));
        }
        else
        {
            return view('distance.create');
        }
    }
    public function create()
    {
        return view('distance.create');
    }
    public function store(Request $request)
    {
        $input['distance'] = $request->distance;
        DB::table('maximum_distance')->insert($input);
        Flash::success('Maximum Distance Saved Successfully!');
        return redirect(route('driverDistance.index'));
    }
    public function edit()
    {
        $distance = DB::table('maximum_distance')->first();
        return view('distance.edit',compact('distance'));
    }
    public function update($id,Request $request)
    {
        $input['distance'] = $request->distance;
        DB::table('maximum_distance')->whereId($id)->update();
        Flash::success('Maximum Distance Updated Successfully!');
        return redirect(route('driverDistance.index'));
    }
}
