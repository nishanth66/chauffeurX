<?php

namespace App\Http\Controllers;

use App\Models\advertisement_users;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class frontEnd extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }
    public function login()
    {
        $domain = request()->getHost();
        if ($domain == env('driver_domain'))
        {
            $siteKey = env('driver_siteKey');
        }
        else
        {
            $siteKey = env('app_siteKey');
        }
        return view('auth.login',compact('siteKey'));
    }
    public function driverRegister()
    {
        $domain = request()->getHost();
        if ($domain == env('driver_domain'))
        {
            $siteKey = env('driver_siteKey');
            return view('drivers.FrontEnd.register',compact('siteKey'));
        }
        else
        {
            $siteKey = env('app_siteKey');
            return view('auth.register',compact('siteKey'));
        }
    }
    public function verification()
    {
        return view('drivers.FrontEnd.verification_code');
    }
    public function SubmitDocument()
    {
        return view('drivers.FrontEnd.ready');
    }
    public function adRegister()
    {
        return view('advertisements.FrontEnd.register');
    }

    public function SaveadRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        if ($validator->passes())
        {
            $input = $request->except('_token','password_confirmation','g-recaptcha-response','password');
            $input['status'] = 2;
            $input['password'] = Hash::make($request->password);
            if ($user = User::create($input))
            {
                $array['email'] = $user->email;
                $email_otp = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
                $array['otp'] = $email_otp;
                Mail::send('emails.verify', ['array' => $array], function ($message) use ($array) {
                    $message->to($array['email'])->subject("Verify Email");
                });
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
                {
                    $input['userid'] = $user->id;
                    $input['email_otp'] = $email_otp;
                    $input['ad_budget'] = 10;
                    advertisement_users::create($input);
                    Flash::success("Registered to ChauffeurX Successfully");
                    return redirect('advertisement/verify');
                }
                else
                {
                    User::whereId($user->id)->forcedelete();
                    Flash::error("Something went wrong! Please try again");
                    return redirect('back');
                }
            }
            else
            {
                Flash::error("Something went wrong! Please try again");
                return redirect('back');
            }
        }
        else
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
