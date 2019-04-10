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
        if (DB::table('maximum_distance')->where('distance','!=',null)->orWhere('distance','!=','')->exists())
        {
            $distance = DB::table('maximum_distance')->first();
            return view('distance.edit',compact('distance'));
        }
        else
        {
            $distance = DB::table('maximum_distance')->first();
            $distance->distance = 0;
            return view('distance.edit',compact('distance'));
        }
    }
    public function adIndex()
    {
        if (DB::table('maximum_distance')->where('ads','!=',null)->orWhere('ads','!=','')->exists())
        {
            $distance = DB::table('maximum_distance')->first();
            $distance = $distance->ads;
            return view('distance.edit2',compact('distance'));
        }
        else
        {
            $distance = 0;
            return view('distance.edit2',compact('distance'));
        }
    }
    public function adSave(Request $request)
    {
        if (DB::table('maximum_distance')->exists())
        {
            DB::table('maximum_distance')->whereId(1)->update(['ads'=>$request->ads]);
            Flash::success("Maximun Distance Updated Successfully");
            return redirect()->back();
        }
        else
        {
            DB::table('maximum_distance')->whereId(1)->create(['ads'=>$request->ads]);
            Flash::success("Maximun Distance Updated Successfully");
            return redirect()->back();
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
        if (DB::table('maximum_distance')->exists())
        {
            DB::table('maximum_distance')->whereId($id)->update($input);
        }
        else
        {
            DB::table('maximum_distance')->create($input);
        }

        Flash::success('Maximum Distance Updated Successfully!');
        return redirect(route('driverDistance.index'));
    }

}
