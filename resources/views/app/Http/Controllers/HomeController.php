<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('home');
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
