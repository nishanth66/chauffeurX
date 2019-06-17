<?php

namespace App\Http\Controllers;

use App\Models\availableCities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;

class penaltyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $penalties = DB::table('driver_penalty')->get();
        return view('drivers.penalty.penalty',compact('penalties'));
    }
    public function create()
    {
        $cities = availableCities::get();
        return view('drivers.penalty.penaltyCreate',compact('cities'));
    }
    public function edit($id)
    {
        $penalty = DB::table('driver_penalty')->whereId($id)->first();
        $cities = availableCities::get();
        return view('drivers.penalty.penaltyEdit',compact('penalty','cities'));
    }
    public function store(Request $request)
    {
        $input = $request->except('_token');
        if (DB::table('driver_penalty')->where('city',$request->city)->exists())
        {
            Flash::error("Entry already exists");
            return redirect(route('penalty.index'));
        }
        DB::table('driver_penalty')->insert($input);
        Flash::success("Driver Penalty Saved Successfully");
        return redirect(route('penalty.index'));
    }
    public function update($id,Request $request)
    {
        $input = $request->except('_token','_method');
        if (DB::table('driver_penalty')->where('city',$request->city)->where('id','!=',$id)->exists())
        {
            Flash::error("Entry already exists");
            return redirect(route('penalty.index'));
        }
        DB::table('driver_penalty')->whereId($id)->update($input);
        Flash::success("Driver Penalty Saved Successfully");
        return redirect(route('penalty.index'));
    }
    public function destroy($id)
    {
        DB::table('driver_penalty')->whereId($id)->delete();
        Flash::success("Driver Penalty Deleted Successfully");
        return redirect(route('penalty.index'));
    }
}
