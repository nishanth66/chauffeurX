<?php

namespace App\Http\Controllers\api;

use App\Models\driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class driverApiController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = Hash::make($request->password);
        if (driver::where('email',$email)->exists()) {
            $driver = driver::where('email', $email)->first();
            if (Hash::check($password, $driver->password) && $email == $driver->email) {
                $response['code'] = 200;
                $response['status'] = "Success";
                $response['message'] = "User Details Fetched successfully";
                $response['data'] = $driver;
            }
            else
            {
                $response['code'] = 500;
                $response['status'] = "Failed";
                $response['message'] = "Email and Password do no match";
                $response['data'] = [];
            }
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "User Not Found!";
            $response['data'] = [];
        }
    }
    public function verify(Request $request)
    {

    }
    public function register(Request $request)
    {

    }


}
