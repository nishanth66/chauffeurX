<?php

namespace App\Http\Controllers;

use App\Models\driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->status == 0 || Auth::user()->status == 10)
        {
            return view('home');
        }
        elseif (Auth::user()->status == 1)
        {
            $driver = driver::where('userid',Auth::user()->id)->first();
            if ($driver->activated != 1)
            {
                return redirect('driver/verify');
            }
            elseif($driver->basic_details != 1)
            {
                return redirect('driver/profile');
            }
            elseif($driver->address_details != 1)
            {
                return redirect('driver/address');
            }
            elseif ($driver->licence_details != 1)
            {
                return redirect('driver/verifyLicence');
            }
            elseif ($driver->documents != 1)
            {
                return redirect('driver/documents');
            }
            elseif (empty($driver->signature) || $driver->signature == '')
            {
                return redirect('driver/agree');
            }
            elseif ($driver->status != 'accepted')
            {
                return redirect('driver/SubmitDocument');
            }
            else
            {
                return redirect('driver/home');
            }
        }
    }
    public function method()
    {
        $i=1;
        $payments = DB::table('payment_methods')->get();
        return view('payments.index',compact('payments','i'));
    }
    public function edit()
    {

    }
    public function show()
    {

    }
    public function destroy()
    {

    }
}
