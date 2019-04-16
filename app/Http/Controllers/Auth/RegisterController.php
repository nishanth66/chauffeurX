<?php

namespace App\Http\Controllers\Auth;

use App\Models\driver;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $sid    = "AC7835895b4de3218265df779b550d793b";
    protected $token  = "c44245d2f7d682f18eb3a1399d8d5ef6";
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        if ($data['status'] == 1)
        {
            $array['email'] = $data['email'];
            $array['phone'] = $data['code'].$data['phone'];
            $phone_otp = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
            $email_otp = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
            $array['otp'] = $email_otp;
            $input['password'] = Hash::make($data['password']);
            $input['code'] = $data['code'];
            $input['phone'] = $data['code'].$data['phone'];
            $input['email'] = $data['email'];
            $input['email_otp'] = $email_otp;
            $input['phone_otp'] = $phone_otp;
            Mail::send('emails.verify', ['array' => $array], function ($message) use ($array) {
                $message->to($array['email'])->subject("Verify Email");
            });
            $response=app('App\Http\Controllers\api\Controller')->sendOtp($this->sid,$this->token,$array['phone'],$phone_otp);
            $driver = driver::create($input);
        }
        if ($data['status'] == 1)
        {
            return User::create([
                'email' => $data['email'],
                'phone' => $data['code'].$data['phone'],
                'password' => Hash::make($data['password']),
                'status' => $data['status'],

            ]);
        }
        else
        {
            return User::create([

                'fname' => $data['name'],
                'lname' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'status' => $data['status'],
            ]);
        }
    }
}
