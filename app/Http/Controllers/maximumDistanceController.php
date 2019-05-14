<?php

namespace App\Http\Controllers;

use App\Models\availableCities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;

class maximumDistanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $distances = DB::table('maximum_distance')->get();
        return view('distance.maxIndex',compact('distances'));
    }

    public function edit($id)
    {
        $cities = availableCities::get();
        if (DB::table('maximum_distance')->whereId($id)->exists() == 0)
        {
            Flash::error("The Distance Record for this City is not Found!");
            return redirect(route('maximumDistance.index'));
        }
        $distance = DB::table('maximum_distance')->whereId($id)->first();
        return view('distance.maxEdit',compact('cities','distance'));
    }

    public function create()
    {
        $cities = availableCities::get();
        return view('distance.maxCreate',compact('cities'));
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        DB::table('maximum_distance')->insert($input);
        Flash::success("Distance Saved Successfully");
        return redirect(route('maximumDistance.index'));
    }

    public function update($id,Request $request)
    {
        $input = $request->except('_token','_method');
        DB::table('maximum_distance')->whereId($id)->update($input);
        Flash::success("Distance Saved Successfully");
        return redirect(route('maximumDistance.index'));
    }


}
