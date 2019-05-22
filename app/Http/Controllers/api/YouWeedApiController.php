<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class preferencesController
 * @package App\Http\Controllers\API
 */

class YouWeedApiController extends Controller
{
    public function login(Request $request){
        $email=$request->email;
        $password=$request->password;
        if (DB::table('you_weed_users')->where('email',$email)->where('password',$password)->exists()){
            $data=DB::table('you_weed_users')->where('email',$email)->where('password',$password)->first();
            $response['code']=200;
            $response['status']="success";
            $response['message']="Logged in Successfully.";
            $response['data']=$data;
        }
        else{
            $response['code']=500;
            $response['status']="failed";
            $response['message']="Enter Valid Email or Password.";
            $response['data']=[];
        }
        return json_encode($response);
    }
    public function register(Request $request){
        if((isset($request->name) && isset($request->email) && isset($request->password) && isset($request->confirm_password) && isset($request->dob) && isset($request->age))){
            $name=              $request->name;
            $email=             $request->email;
            $password=          $request->password;
            $confirm_password=  $request->confirm_password;
            $dob=               $request->dob;
            $age=               $request->age;

            if(empty($email) || empty($name) || empty($password) || empty($confirm_password) || empty($dob) || empty($age)){
                if($password == $confirm_password){
                    $input = [
                        'name'      =>  $name,
                        'email'     =>  $email,
                        'password'  =>  $password,
                        'dob'       =>  $dob,
                        'age'       =>  $age,
                        'unique_id' =>  rand(5).'_'.time()
                    ];
                    $data = DB::table('you_weed_users')->insert($input);

                    $response['code']=200;
                    $response['status']="success";
                    $response['message']="Signed Up Successfully.";
                    $response['data']=$data;
                }
                else{
                    $response['code']=500;
                    $response['status']="failed";
                    $response['message']="Password and Confirm Password not matched.";
                    $response['data']=[];
                }
            }
            else{
                $response['code']=500;
                $response['status']="failed";
                $response['message']="All fields are required.";
                $response['data']=[];
            }
        }
        else{
            $response['code']=500;
            $response['status']="failed";
            $response['message']="All fields are required.";
            $response['data']=[];
        }
        return json_encode($response);
    }
    public function userDetails(Request $request){
        if(DB::table('you_weed_users')->where('id',$request->user_id)->exists()){
            $data = DB::table('you_weed_users')->where('id',$request->user_id)->first();
            $response['code']=200;
            $response['status']="success";
            $response['message']="Signed Up Successfully.";
            $response['data']=$data;
        }
        else{
            $response['code']=500;
            $response['status']="failed";
            $response['message']="User not Found.";
            $response['data']=[];
        }
        return json_encode($response);
    }
}
