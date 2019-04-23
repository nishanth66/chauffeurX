<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class frontEnd extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }
    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('drivers.FrontEnd.register');
    }
    public function verification()
    {
        return view('drivers.FrontEnd.verification_code');
    }
    public function SubmitDocument()
    {
        return view('drivers.FrontEnd.ready');
    }
}
