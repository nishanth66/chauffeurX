<?php

namespace App\Http\Controllers\api;

use App\Models\advertisement;
use App\Models\booking;
use App\Models\categories;
use App\Models\cencellation;
use App\Models\driver;
use App\Models\driverCategory;
use App\Models\driverTips;
use App\Models\favDriver;
use App\Models\filter;
use App\Models\invitedFriends;
use App\Models\passengers;
use App\Models\passengerStripe;
use App\Models\price;
use App\Models\rating;
use App\Models\userCoupons;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Edujugon\PushNotification\PushNotification;
use \Carbon\Carbon;

class passengerApiController extends Controller
{
    protected $googleMap = "AIzaSyB56Xh1A7HQDPQg_7HxrPTcSNnlpqYavc0";
    private $database;
    public function __construct()
    {
        $config = array(
            "type"=> "service_account",
            "project_id"=> "driverapp-master-bb0a8",
            "private_key_id"=> "5133dcc7296c8d6c3c5344f2442ac8108958e788",
            "private_key"=> "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDJxY02bLvVQMRN\nSQRwQNjjzzYKx3CTvb418mmg60TYiFCjx8U9EO4JrqtEl6rbttKC55gYD7TTUH3c\nPQMfhKybk4wEBRYFDtNAVNVlQW+W3EzqoN2sXxCaDbr644CAGW40GIq+MSo+HGxU\n13TifJ4FB3lCj2xSLY7XtaUAiyCZ9AiW/wlFd5GuF+gjIagkb2kPGuocg9WM1qvs\nWTDxtIcubnmQXz2xOATnIS1c9s4oNcI7DxfdTxSzB9AZ0bZUvTF+OzEGIz3gARqq\nlqDyE+LejdBtm18q0uHFSRKrtmfRnr8GWpe1QpoKIZ/kTEKpdlUYGUC97mZFjo7S\nify8LrV/AgMBAAECggEAGn5/v+VANszV2eYcGJdTQ3qaeIjere+s0c2edBxggmRH\n3nGlYxLdhtTyNUQLEeWsN7csYABz+IlptWknh1R3C8iwiniWfxyGvbxF9xFEE1Wj\nHe34naEv/2KNKlOENI3iTCHq2fV/u/8kdHGELhc58qQcFpLZoOLNjmKSI4OhSMWo\nSS0s6pHF56H3cixgueCTwTAzURcIdvzfFo2PE0QrPbTEoC+0AA+hvfBTtS/Zf94A\nulg5Eh6TBC1Qzjt6EyuVJ/HldmCRG97XUUY09q99szWmVLO1ANulYlCuRLGeTtlf\nLWW1YRYJIWJfVVa8vnosl/HAWtt8FKPqJxV2SatobQKBgQDkVeEDiOpZm7ox3zqj\nbFVv7rTLSjq9hZHk6Gh77oaxnOlmH4gih8mGh/z5Qyi4R9y5zXeOJHuJg72mnqsK\nGEMZ5nVPpKwRE4N1mSPw0Y/uVeNmyVDhWFmdu9XIpj49XAGMXr54kLjQSZ1IoueE\nB0WZ7cAxKYu5TzgTnIgQev4BZQKBgQDiN8M2bWpLj0xhlQvlA74e+Ti5YrQkVCiH\nbi6vIJ9p2mc2qg0ysymxAFiWDAtvnvIhXJ83MI81IUSwWBWLHzMluPh8No10/DVw\nlqkiqV/YEtJg4qCucar7qQEJsbODjpFQBfXZemE8DD3Q1LhwemOwI94K0Q/nCtWp\ndHX9eZ3/EwKBgH7B5h5uPZrtRpo1EHp0w6FV5OwOEznvEqT/GDHkosWrFC7rRknV\nE90pVRiTXeGfkztagwpX2nTmu7vpzY3XFjkkpO9HvXXlXU9Fapxf2gU3jPwcule/\nElDsW6v+DgNGNl3UouyPeum2VChktx2mY88mG1GvfK+s+LZ6aVas0KG5AoGBAJtn\nr2XOmL07vj8zQy6a+ZsRntRMaHCkmAshuFR61sjDTzCQdeykhDmigTjjIWAXE0Oz\n+3TQmTDon+V9PZ+LWXnKrnm2iEsbkCK+fYbgUIWBuKDyT2xHjizAl4PvXeE8qbsN\nvS0gE3hK+JRj7ijnC2DP4xQPNxuDp/B3ny74w3+dAoGBALjSMp+8nOxWE2sco4wS\nIzOprQ10K54naiy6xx6VsNamaqe9r4KiXXT9qpSjfCg3yMD5swtWVIcwwk0VM8J3\nj/8sgwfGCepyzcmXxZKqmJmfHlxr6Hd+/AA4Nm/MEbeWG+o3eMmZ4LzSS0sSH/fC\nO+f511UqvJxT2UvDVRtJcO70\n-----END PRIVATE KEY-----\n",
            "client_email"=> "driverapp-master-bb0a8@appspot.gserviceaccount.com",
            "client_id"=> "117555270648372527156",
            "auth_uri"=> "https://accounts.google.com/o/oauth2/auth",
            "token_uri"=> "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url"=> "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url"=> "https://www.googleapis.com/robot/v1/metadata/x509/driverapp-master-bb0a8%40appspot.gserviceaccount.com"
        );


        $serviceAccount = ServiceAccount::fromArray($config);

        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();


        $this->database = $firebase->getDatabase();
    }
    //


//  *************************  functions related to Personal Info Login/Register Starts here *****************************

    public function login(Request $request)
    {
        $mNumber = $request->phone;
        if (passengers::where('phone',$mNumber)->exists())
        {
            $otp = substr(str_shuffle("0123456789"), 0, 4);
            $sid    = "AC7835895b4de3218265df779b550d793b";
            $token  = "c44245d2f7d682f18eb3a1399d8d5ef6";
            $twilio = new Client($sid, $token);

            try
            {
                $message = $twilio->messages
                    ->create($mNumber, // to
                        array("from" => "+19562759175",
                            "body" => "Your ChauffeurX verification code is: ".$otp
                        )
                    );
            }
            catch (RestException $ex)
            {
                $response['status'] = 500;
                $response['message'] = "Otp Send Failed";
                $response['data'] = $ex->getMessage();
                return $response;
            }
            $user = passengers::where('phone',$request->phone)->update(['otp' => $otp]);
            $response['status'] = 200;
            $response['message'] = "Otp Sent Successfully";
            $response['number'] = $mNumber;
            $response['data'] = [];
        }
        else
        {
            $response['status'] = 500;
            $response['message'] = "User Not Found";
            $response['number'] = $mNumber;
            $response['data'] = [];
        }
        return $response;
    }

    public function verify(Request $request)
    {
        if (passengers::where('phone',$request->phone)->where('otp',$request->otp)->exists())
        {
            $user = passengers::where('phone',$request->phone)->where('otp',$request->otp)->first();
            if ($user->image != '' || !empty($user->image))
            {
                $user->image = asset('public/avatars').'/'.$user->image;
            }
            if ($user->exists_user == 1)
            {
                $response['status'] = "success";
                $response['code'] = 200;
                $response['Message'] = "OTP Verified Successfully";
                $response['data'] = $user;
            }
            else
            {
                $response['status'] = "success";
                $response['code'] = 250;
                $response['Message'] = "OTP Verified Successfully";
                $response['data'] = $user;
            }
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['Message'] = "Invalid OTP";
            $response['data'] = [];
        }
        return $response;
    }

    public function profile(Request $request)
    {
        if (isset($request->password) && $request->password != $request->confirm_password)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['Message'] = "Two Passwords Do not Match";
            $response['data'] = [];
            return $response;
        }
        $mNumber = $request->phone;
        if (passengers::whereId($request->userid)->where('phone',$mNumber)->exists())
        {
            $user = passengers::whereId($request->userid)->where('phone',$mNumber)->first();
            $update = $request->except('except','password','confirm_password');
            if (isset($request->password) && $request->password != '')
            {
                $update['password'] = Hash::make($request->password);
            }
            if($request->hasFile('image'))
            {

                $photoName = rand(1, 777777777) . time() . '.' . $request->image->getClientOriginalExtension();
                $mime = $request->image->getClientOriginalExtension();
                $request->image->move(public_path('avatars'), $photoName);
                $update['image'] = $photoName;

            }
            $update['exists_user'] = 1;
            $user = passengers::whereId($user->id)->update($update);
            $user = passengers::whereId($request->userid)->where('phone',$mNumber)->first();
            if ($user->image != '' || !empty($user->image))
            {
                $user->image = asset('public/avatars').'/'.$user->image;
            }
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['Message'] = "User Registered Successfully";
            $response['data'] = $user;
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['Message'] = "User Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function userDetails(Request $request)
    {
        if (passengers::whereId($request->userid)->exists())
        {
            $user = passengers::whereId($request->userid)->first();
            if ($user->image != '' || !empty($user->image))
            {
                $user->image = asset('public/avatars').'/'.$user->image;
            }
            $user = $user->makeHidden(['remember_token','email_verified_at','otp']);
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "User details fetched successfully";
            $response['data'] = $user;
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "User not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function register(Request $request)
    {
        $mNumber = $request->phone;
        if (passengers::where('phone',$mNumber)->exists())
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['Message'] = "User with This Phone number is already exists";
            $response['data'] = [];
            return $response;
        }
        elseif (passengers::where('email',$request->email)->exists())
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['Message'] = "User with same Email is aready exists";
            $response['data'] = [];
            return $response;
        }
        $otp = substr(str_shuffle("0123456789"), 0, 4);
        $sid    = "AC7835895b4de3218265df779b550d793b";
        $token  = "c44245d2f7d682f18eb3a1399d8d5ef6";
        $twilio = new Client($sid, $token);

        try
        {
            $message = $twilio->messages
                ->create($mNumber, // to
                    array("from" => "+19562759175",
                        "body" => "Your ChauffeurX verification code is: ".$otp
                    )
                );
        }
        catch (RestException $ex)
        {
            $response['status'] = 500;
            $response['message'] = "Otp Send Failed";
            $response['data'] = $ex->getMessage();
            return $response;
        }

        $user = passengers::create(['phone'=>$mNumber,'otp'=>$otp,'email'=>$request->email]);
        if ($user->image != '' || !empty($user->image))
        {
            $user->image = asset('public/avatars').'/'.$user->image;
        }
        $response['status'] = "Success";
        $response['code'] = 200;
        $response['Message'] = "User Registered Successfully";
        $response['data'] = $user;

        return $response;
    }

    public function editProfile(Request $request)
    {
        if (passengers::where('phone',$request->phone)->exists())
        {
            $update = $request->all('except','password','confirm_password');
            $user = passengers::where('phone',$request->phone)->first();
            if($request->hasFile('image'))
            {

                $photoName = rand(1, 777777777) . time() . '.' . $request->image->getClientOriginalExtension();
                $mime = $request->image->getClientOriginalExtension();
                $request->image->move(public_path('avatars'), $photoName);
                $update['image'] = $photoName;

            }
            $update = $request->all('except','password','confirm_password');
            passengers::where('phone',$request->phone)->update($update);
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['Message'] = "Profile Updated Successfully!";
            $response['data'] = [];
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['Message'] = "User Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function addStripeCard(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "User not found";
            $response['data'] = [];
            return $response;
        }
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
        ]);
        if ($validator->fails())
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "Card Details are Missing";
            $response['data'] = [];
            return $response;
        }
        $user = passengers::whereId($request->userid)->first();
        $token = $stripe->tokens()->create([
            'card' => [
                'number' => $request->get('card_no'),
                'exp_month' => $request->get('ccExpiryMonth'),
                'exp_year' => $request->get('ccExpiryYear'),
                'cvc' => $request->get('cvvNumber'),
            ],
        ]);

        if(empty($user->stripe_id)){
            $customer = $stripe->customers()->create([
                'email' => $user->email,
                'description' => 'Stripe Customer with user id -'.$user->id,
            ]);
            $customerId = $customer['id'];
            passengers::whereId($user->id)->update(['stripe_id' => $customerId]);
        }
        else{
            $customer = $stripe->customers()->find($user->stripe_id);
            $customerId = $customer['id'];
        }
        if(passengerStripe::where('userid',$user->id)->exists()==0)
        {
            $stripe_input['status'] = 1;
        }
        $stripe_fingerprint = $token['card']['fingerprint'];
        if (passengerStripe::where('userid',$user->id)->where('fingerprint',$stripe_fingerprint)->exists()==0)
        {
            $cards = $stripe->cards()->create($customerId, $token['id']);
            $stripe_input['userid'] = $user->id;
            $stripe_input['brand'] = $token['card']['brand'];
            $stripe_input['customerId'] = $customerId;
            $stripe_input['cardNo'] = $cards['id'];
            $stripe_input['fingerprint'] = $stripe_fingerprint;
            $stripe_input['digits'] = 'XXXXXXXXXXXX'.$token['card']['last4'];
            $stripeCards = passengerStripe::create($stripe_input);

            $response['status'] = "Success";
            $response['code'] = 200;
            $response['Message'] = "Stripe Cards Saved Successfully";
            $response['data'] = $stripeCards;
            return $response;
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "This card is already Exists";
            $response['data'] = [];
            return $response;
        }

    }

    public function activateCard(Request $request)
    {
        if (passengers::whereId($request->userid)->exists()==0)
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "User not Found";
            $response['data'] = [];
            return $response;
        }
        if (passengerStripe::whereId($request->cardId)->where('userid',$request->userid)->exists())
        {
            $card = passengerStripe::whereId($request->cardId)->where('userid',$request->userid)->first();
            $stripe = Stripe::make(env('STRIPE_SECRET'));
            passengerStripe::where('userid',$request->userid)->where('status',1)->update(['status'=>0]);
            $stripeCard=passengerStripe::where('userid',$request->userid)->whereId($request->cardId)->update(['status'=>1]);
            $customer = $stripe->customers()->update( $card->customerId, [
                'default_source' => $card->cardNo
            ]);
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['Message'] = "Card Activated Successfully";
            $response['data'] = $stripeCard;
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "Card Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function getStripeCards(Request $request)
    {
        if (passengers::whereId($request->userid)->exists())
        {
            if (passengerStripe::where('userid',$request->userid)->exists())
            {
                $cards = passengerStripe::where('userid',$request->userid)->get();
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "User Stripe cards have been Fetched successfully";
                $response['data'] = $cards;
            }
            else
            {
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "User has no Srtipe Cards";
                $response['data'] = [];
            }
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "User not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function getPaymentMethods()
    {
        $payments = DB::table('payment_methods')->get();
        if (empty($payments))
        {
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "No Payment Statuses are Defined";
            $response['data'] = [];
        }
        else
        {
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "Payment Statuses are Fetched Successfully";
            $response['data'] = $payments;
        }
        return $response;
    }

//**********************************************************************************************************************

//******************************Functions related to bookings **********************************************************

    public function driverRating(Request $request)
    {
        if (driver::whereId($request->driverid)->exists())
        {
            if (rating::where('driverid',$request->driverid)->exists())
            {
                $ratings = rating::where('driverid',$request->driverid)->get();
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "Driver data Fetched Successfully";
                $response['data'] = $ratings;
            }
            else
            {
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "No Driver Ratings are Found";
                $response['data'] = [];
            }
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "Driver Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function getNearbyDrievrs(Request $request)
    {
        if (isset($request->categoryid) && (!empty($request->categoryid) || $request->categoryid != ''))
        {
            if (categories::whereId($request->categoryid)->exists() == 0)
            {
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['message'] = "Category Not Found";
                $response['data'] = [];
                return $response;
            }
            if (driverCategory::where('categoryid',$request->categoryid)->exists() == 0)
            {
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['message'] = "No drivers are found on this category";
                $response['data'] = [];
                return $response;
            }
        }

        $userDetais = explode('-',$request->user_lat_lng);
        if ((!isset($userDetais[0]) || $userDetais[0] == '' || empty($userDetais[0])) || (!isset($userDetais[1]) || $userDetais[1] == '' ||  empty($userDetais[1])) || (!isset($userDetais[2]) || $userDetais[2] == '' || empty($userDetais[2])))
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Invalid user data Received! Format- user_lat_lng = 'userid-lat-lng'";
            $response['data'] = [];
            return $response;
        }

        $lat1 = $userDetais[1];
        $long1 = $userDetais[2];
        if (isset($request->categoryid) && (!empty($request->categoryid) || $request->categoryid != ''))
        {
            $drivers = $this->driverByCategory($request->categoryid);
        }
        else
        {
            $drivers = driver::where('isAvailable',1)->get();
        }
        if (count($drivers) == 0)
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "No drivers are Active at the moment";
            $response['data'] = [];
            return $response;
        }
        $response = $this->fetchNearbyDrivers($drivers,$lat1,$long1);
        return $response;
    }

    public function getCategories()
    {
        $categories = categories::get();
        foreach ($categories as $category)
        {
            if ($category->image != '' || !empty($category->image))
            {
                $category->image = asset('public/avatars').'/'.$category->image;
            }
        }

        if (empty($categories))
        {
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "No Categories are Found";
            $response['data'] = [];
        }
        else
        {
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "Categories are Fetched Successfully";
            $response['data'] = $categories;
        }
        return $response;
    }

    public function displayPrice(Request $request)
    {
        if (categories::exists() == 0)
        {
            $response['code'] = 500;
            $response['status']     = 'failed';
            $response['message']    = 'Admin didnt setup any Category';
            $response['data']    = [];
        }
        $src= explode( ",", $request->source);
        if ( isset( $src[0] ) && isset( $src[1] ) ) {
            $latSrc = $src[0];
            $lonSrc = $src[1];
        } else {
            $response['code'] = 500;
            $response['status']     = 'failed';
            $response['message']    = 'Enter Valid Source Location.';

            return $response;
        }
        $dest = explode( ",", $request->destination );
        if ( isset( $dest[0] ) && isset( $dest[1] ) ) {
            $latDest = $dest[0];
            $lonDest = $dest[1];
        } else {
            $response['code'] = 500;
            $response['status']     = 'failed';
            $response['message']    = 'Enter Valid Destination Location.';

            return $response;
        }
        $distanceTime = $this->calculateDistance($latSrc,$lonSrc,$latDest,$lonDest);
        $distance = $distanceTime['distance'];
        $time = $distanceTime['time'];
        $categories = categories::get();
        $rideDetails = [];
        foreach ($categories as $category)
        {
            if (price::where('category',$category->id)->exists())
            {
                $categoryPrice = price::where('category',$category->id)->first();
                $totalPrice = (float)$distance*(float)$categoryPrice->amount;
                $array['category_id'] = $category->id;
                $array['category_name'] = $category->name;
                $array['category_image'] = asset('public/avatars').'/'.$category->image;
                $array['distance'] = $distance;
                $array['estimated_time'] = $time;
                $array['estimated_price'] = number_format($totalPrice);
                array_push($rideDetails,$array);
            }
        }
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Ride details fetched";
        $response['data'] = $rideDetails;
        return $response;
    }

    public function validatePromoCode(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "User Not Found";
            $response['data'] = [];
            return $response;
        }
        if (userCoupons::where('userid',$request->userid)->where('code',$request->promoCode)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Invalid Promo-Code";
            $response['valid'] = 0;
            $response['data'] = [];
        }
        else
        {
            $userCode = userCoupons::where('userid',$request->userid)->where('code',$request->promoCode)->first();
            if ($userCode->status == 0)
            {
                $discountPercentage = (float)str_replace(',','',$userCode->discount);
                $oldPrice = (float)str_replace(',','',$request->trip_price);
                $totalDiscount = ($oldPrice*$discountPercentage)/100;
                $newPrice = $oldPrice-$totalDiscount;
                $response['code'] = 200;
                $response['status'] = "Success";
                $response['message'] = "Promo-code is Valid!";
                $response['old_trip_price'] = number_format($oldPrice);
                $response['new_trip_price'] = number_format($newPrice);
                $response['valid'] = 1;
                $response['data'] = [];
            }
            else
            {
                $response['code'] = 500;
                $response['status'] = "Failed";
                $response['message'] = "You have already this Promo-Code!";
                $response['valid'] = 0;
                $response['data'] = [];
            }
        }
        return $response;
    }

    public function RequestBooking(Request $request)
    {
        if (passengers::whereId($request->userid)->where('phone',$request->phone)->exists())
        {
            $input = $request->all();
            $src= explode( ",", $request->source);
            if ( isset( $src[0] ) && isset( $src[1] ) ) {
                $latSrc = $src[0];
                $lonSrc = $src[1];
            } else {
                $response['code'] = 500;
                $response['status']     = 'failed';
                $response['message']    = 'Enter Valid Source Location.';

                return $response;
            }
            $dest = explode( ",", $request->destination );
            if ( isset( $dest[0] ) && isset( $dest[1] ) ) {
                $latDest = $dest[0];
                $lonDest = $dest[1];
            } else {
                $response['code'] = 500;
                $response['status']     = 'failed';
                $response['message']    = 'Enter Valid Destination Location.';

                return $response;
            }
            $distanceTime = $this->calculateDistance($latSrc,$lonSrc,$latDest,$lonDest);
            $input['distance'] = $distanceTime['distance'];
            $input['estimated_time'] = $distanceTime['time'];
            $price = $discountedPrice = $this->calculatePrice($request->categoryId,$input['distance']);
            $input['original_price'] = $price;
            $input['price'] = $price;
            if (isset($request->promoCode) && ($request->promoCode != '' || !empty($request->promoCode)))
            {
                if (userCoupons::where('userid',$request->userid)->where('code',$request->promoCode)->exists() == 0)
                {
                    $response['status'] = "failed";
                    $response['code'] = 500;
                    $response['Message'] = "Invalid Promo-Code";
                    $response['Data'] = [];
                    return $response;
                }
                else
                {
                    $userCode = userCoupons::where('userid',$request->userid)->where('code',$request->promoCode)->first();
                    if ($userCode->status != 0)
                    {
                        $response['status'] = "failed";
                        $response['code'] = 500;
                        $response['Message'] = "This code has already used";
                        $response['Data'] = [];
                        return $response;
                    }
                    else
                    {
                        $discount = (float)$userCode->discount;
                        $totalDiscount = ($discount*$price)/100;
                        $discountedPrice = $price-$totalDiscount;
//                        $input['price'] = $discountedPrice;
                    }
                }
            }


            $response['status'] = "Success";
            $response['code'] = 200;
            $response['estimated_price'] = $input['price'];
            $response['estimated_price_after_discount'] = $discountedPrice;
            $response['distance'] = $input['distance'];
            $response['estimated_time'] = $input['estimated_time'];
            $response['data'] = [];
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['Message'] = "User Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    function assignDriver($driverid,$lat1,$long1)
    {
        $score[$driverid] = 1/$this->getDriverWaitTime($driverid,$lat1,$long1);
//        return $score;
        $score = (1/$this->getDriverWaitTime($driverid,$lat1,$long1))+($this->getDriverRating($driverid)/10)+($this->driverSevenBookings($driverid)/100)-($this->getPenalty($driverid));
        return $score;
    }

    function getDriverWaitTime($driverid,$lat1,$long1)
    {
        $driver = driver::whereId($driverid)->first();
        $coordinates=$this->database->getReference('online_drivers')->getChild($driver->device_token)->getValue();
        $lat2 = $coordinates['lat'];
        $long2 = $coordinates['lng'];
        $distance = $this->calculateDistance($lat1,$long1,$lat2,$long2);
        $minutes = $distance['min'];
        return $minutes;
    }

    function driverSevenBookings($driverid)
    {
        $date = Carbon::today()->subDays(7);

        $bookings = booking::where('driverid',$driverid)->where('trip_end_time','>=',$date)->count();
        return $bookings;
    }

    function getPenalty($driverid)
    {
        $driver = driver::whereId($driverid)->first();
        if ($driver->penalty != '' || !empty($driver->penalty) || $driver->penalty == null)
        {
            $penalty = (float)$driver->penalty;
        }
        else
        {
            $penalty = 0;
        }
        return $penalty;
    }

    function getDriverRating($driverid)
    {
        $count = rating::where('driverid',$driverid)->count();
        if ($count > 0)
        {
            $totalRating = rating::where('driverid',$driverid)->sum('rating');
            $rate = (($totalRating/$count)*100)/5;
        }
        else
        {
            $rate = 0;
        }
        return $rate;

    }

    public function booking(Request $request)
    {
        if (passengers::whereId($request->userid)->where('phone',$request->phone)->exists())
        {
            $input = $request->except('image','promoCode');
            $src= explode( ",", $request->source);
            if ( isset( $src[0] ) && isset( $src[1] ) ) {
                $latSrc = $src[0];
                $lonSrc = $src[1];
            }
            else {
                $response['code'] = 500;
                $response['status']     = 'failed';
                $response['message']    = 'Enter Valid Source Location.';

                return $response;
            }
            $dest = explode( ",", $request->destination );
            if ( isset( $dest[0] ) && isset( $dest[1] ) ) {
                $latDest = $dest[0];
                $lonDest = $dest[1];
            }
            else {
                $response['code'] = 500;
                $response['status']     = 'failed';
                $response['message']    = 'Enter Valid Destination Location.';

                return $response;
            }
            $distanceTime = $this->calculateDistance($latSrc,$lonSrc,$latDest,$lonDest);
            $input['distance'] = $distanceTime['distance'];
            $input['estimated_time'] = $distanceTime['time'];
            $price = $this->calculatePrice($request->categoryId,$input['distance']);
            $input['original_price'] = $price;
            $input['price'] = $price;
            if($request->hasFile('image'))
            {
                $validator=Validator::make($request->all(), [
                        'image' => 'mimes:jpg,png,gif,jpeg,PNG,svg',
                    ]
                );
                if ($validator->passes())
                {
                    $photoName = rand(1, 777777777) . time() . '.' . $request->image->getClientOriginalExtension();
                    $mime = $request->image->getClientOriginalExtension();

                    $this->compress($request->image, public_path('avatars') . '/' . $photoName, 100, $mime);
                    $input['image'] = $photoName;
                }
                else
                {
                    $response['status'] = "failed";
                    $response['code'] = 500;
                    $response['Message'] = "Un-Supported Image Format";
                    $response['Data'] = [];
                    return $response;
                }
            }
            if (isset($request->promoCode) && ($request->promoCode != '' || !empty($request->promoCode)))
            {
                if (userCoupons::where('userid',$request->userid)->where('code',$request->promoCode)->exists() == 0)
                {
                    $response['status'] = "failed";
                    $response['code'] = 500;
                    $response['Message'] = "Invalid Promo-Code";
                    $response['Data'] = [];
                    return $response;
                }
                else
                {
                    $userCode = userCoupons::where('userid',$request->userid)->where('code',$request->promoCode)->first();
                    if ($userCode->status != 0)
                    {
                        $response['status'] = "failed";
                        $response['code'] = 500;
                        $response['Message'] = "This code has already used";
                        $response['Data'] = [];
                        return $response;
                    }
                    else
                    {
                        $discount = (float)$userCode->discount;
                        $totalDiscount = ($discount*$price)/100;
                        $discountedPrice = $price-$totalDiscount;
                        $input['price'] = $discountedPrice;
                    }
                }
            }

            $userDetais = explode('-',$request->user_lat_lng);
            if ((!isset($userDetais[0]) || $userDetais[0] == '' || empty($userDetais[0])) || (!isset($userDetais[1]) || $userDetais[1] == '' ||  empty($userDetais[1])))
            {
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['message'] = "Invalid user data Received! Format- user_lat_lng = 'userid-lat-lng'";
                $response['data'] = [];
                return $response;
            }

            $lat1 = $userDetais[0];
            $long1 = $userDetais[1];

            $drivers = $this->driverByCategory($request->categoryId);
            if (count($drivers) == 0)
            {
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['message'] = "No drivers are Active at the moment";
                $response['data'] = [];
                return $response;
            }
            $response = $this->fetchNearbyDrivers($drivers,$lat1,$long1);
            $driverScore = [];
            if ($response['code'] != 200 || count($response['data']) < 1)
            {
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['message'] = "No drivers are Active at the moment";
                $response['data'] = [];
                return $response;
            }
            foreach($response['data'] as $driver)
            {
                if (driver::whereId($driver['driverid'])->where('isAvailable',1)->exists())
                {
                    $driverid = $driver['driverid'];
                    $score[$driverid] = $this->assignDriver($driverid,$lat1,$long1);
                }
            }
            if (isset($score) && count($score) > 0)
            {
                $driverid = array_search(max($score),$score);
                $driver_score = max($score);
//                ******************* Push notification ********************
//                                    Code to push notification
                $input['driverid'] = $driverid;
//********************************************************************************************
                unset($score[$driverid]);
                $newScore = "";
                foreach ($score as $key => $value)
                {
                    if ($newScore == "")
                    {
                        $newScore .= $key.'-'.$value;
                    }
                    else
                    {
                        $newScore .=','.$key.'-'.$value;
                    }
                }

            }
            else
            {
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['message'] = "No drivers are Active at the moment";
                $response['data'] = [];
                return $response;
            }

            $booking = booking::create($input);
            DB::table('bookingDriver_push')->insert(['bookingid'=>$booking->id,'array'=>$newScore]);

            if (isset($request->promoCode) && ($request->promoCode != '' || !empty($request->promoCode))) {
                if (userCoupons::where('userid', $request->userid)->where('code', $request->promoCode)->exists())
                {
                    userCoupons::where('userid', $request->userid)->where('code', $request->promoCode)->update(['status' => 1]);
                }
            }
            if ($booking->image != '' || !empty($booking->image))
            {
                $booking->image = asset('public/avatars').'/'.$booking->image;
            }
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['Message'] = "Booking Saved Successfully!";
            $response['data'] = $booking;
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['Message'] = "User Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function editBooking(Request $request)
    {
        if (booking::whereId($request->bookingId)->exists())
        {
            $update = $request->except('image','bookingId');
            if((isset($request->source) && isset($request->destination)) || ($request->source != '' && $request->destination != ''))
            {
                $src= explode( ",", $request->source);
                if ( isset( $src[0] ) && isset( $src[1] ) ) {
                    $latSrc = $src[0];
                    $lonSrc = $src[1];
                } else {
                    $response['code'] = 500;
                    $response['status']     = 'failed';
                    $response['message']    = 'Enter Valid Source Location.';

                    return $response;
                }
                $dest = explode( ",", $request->destination );
                if ( isset( $dest[0] ) && isset( $dest[1] ) ) {
                    $latDest = $dest[0];
                    $lonDest = $dest[1];
                } else {
                    $response['code'] = 500;
                    $response['status']     = 'failed';
                    $response['message']    = 'Enter Valid Destination Location.';

                    return $response;
                }
                $distanceTime = $this->calculateDistance($latSrc,$lonSrc,$latDest,$lonDest);
                $update['distance'] = $distanceTime['distance'];
                $update['estimated_time'] = $distanceTime['time'];
                $update['price'] = $this->calculatePrice($request->categoryId,$update['distance']);
            }

            if($request->hasFile('image'))
            {
                $photoName = rand(1, 777777777) . time() . '.' . $request->image->getClientOriginalExtension();
                $mime = $request->image->getClientOriginalExtension();
                $request->image->move(public_path('avatars'), $photoName);
                $update['image'] = $photoName;
            }
            booking::whereId($request->bookingId)->update($update);
            $booking = booking::whereId($request->bookingId)->first();
            if ($booking->image != '' || !empty($booking->image))
            {
                $booking->image = asset('public/avatars').'/'.$booking->image;
            }
            $response['status'] = "Success";
            $response['code'] = 500;
            $response['message'] = "Booking Edited Successfully";
            $response['data'] = $booking;
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 200;
            $response['message'] = "Booking not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function cancelBookingFee(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        if (passengers::whereId($request->userid)->exists())
        {
            if (booking::whereId($request->bookingid)->where('userid',$request->userid)->exists())
            {
                $booking = booking::whereId($request->bookingid)->where('userid',$request->userid)->first();
                if (cencellation::exists())
                {
                    $cancellation = cencellation::first();
                    $cancellationFee = (int)$cancellation->amount;
                    $max_time = (int)$cancellation->max_time;
                }
                else
                {
                    $cancellationFee = 0;
                    $max_time=1;
                }
                $now = time();
                $bookingTime = strtotime(str_replace('/','-',$booking->trip_date_time));
//                return date('d/m/Y h:i',$now);
                $date = $now-$bookingTime;
                $minute_difference = round(abs($date) / 60,2);
                if ($minute_difference > $max_time)
                {
                    $response['status'] = "Success";
                    $response['code'] = 200;
                    $response['message'] = "Cancellation Fees Obtained Successfully";
                    $response['data'] = $cancellationFee;
                }
                else
                {
                    $cancellationFee= 0;
                    $response['status'] = "Success";
                    $response['code'] = 200;
                    $response['message'] = "Cancellation Fees Obtained Successfully";
                    $response['data'] = $cancellationFee;
                }
            }
            else
            {
                $response['status'] = "Failed";
                $response['code'] = 400;
                $response['message'] = "Booking not Found";
                $response['data'] = [];
            }
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "User not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function cancelBooking(Request $request)
    {
        if (booking::whereId($request->bookingid)->where('userid',$request->userid)->exists() == 0)
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Booking not Found";
            $request['data'] = [];
            return $response;
        }
        elseif(booking::whereId($request->bookingid)->where('userid',$request->userid)->where('cancelled_at',null)->orWhere('cancelled_at','')->exists())
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Booking is already Cancelled";
            $request['data'] = [];
            return $response;
        }
        else
        {
            $updateBooking['status'] = "cancelled";
            $updateBooking['cancelled_at'] = new \DateTime();
            booking::whereId($request->bookingid)->update($updateBooking);
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "Booking Cancelled Successfully!";
            $response['data'] = booking::whereId($request->bookingid)->first();
            return $response;
        }
    }

    public function rateRide(Request $request)
    {
        if (booking::whereId($request->bookingId)->where('userid',$request->userid)->exists())
        {
            $booking = booking::whereId($request->bookingId)->where('userid',$request->userid)->first();
            $rate = rating::create([
                'userid'=>$request->userid,
                'booking_id'=>$request->bookingId,
                'driverid'=>$booking->driverid,
                'rating'=>$booking->rating,
                'comments'=>$booking->comments,
            ]);
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['Message'] = "Rating saved Successfully";
            $response['data'] = $rate;
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "Booking Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function allBooking()
    {
        if (booking::exists())
        {
            $bookings = booking::get();
            foreach ($bookings as $booking)
            {
                if ($booking->image != '' || !empty($booking->image))
                {
                    $booking->image = asset('public/avatars').'/'.$booking->image;
                }
            }
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "Bookings fetched Successfully";
            $response['data'] = $bookings;
        }
        else
        {
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "No bookings Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function rideHistory($userid)
    {
        if (passengers::whereId($userid)->exists())
        {
            $user = passengers::whereId($userid)->first();
            if (booking::where('userid',$user->id)->where('completed',1)->exists())
            {
                $bookings = booking::where('userid',$user->id)->where('completed',1)->get();
                foreach ($bookings as $booking)
                {
                    if ($booking->image != '' || !empty($booking->image))
                    {
                        $booking->image = asset('public/avatars').'/'.$booking->image;
                    }
                }
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "User Ride History";
                $response['data'] = $bookings;
            }
            else
            {
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "User Ride History is Empty!";
                $response['data'] = [];
            }
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "User Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function getRideRating(Request $request)
    {
        if (booking::whereId($request->bookingId)->exists())
        {
            $booking = booking::whereId($request->bookingId)->first();
            if (rating::where('booking_id',$booking->id)->exists())
            {
                $rate = rating::where('booking_id',$booking->id)->first();
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "Rating Fetched Succeessfully";
                $response['data'] = $rate;
            }
            else
            {
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "Rating for Booking is Empty";
                $response['data'] = [];
            }
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "Booking Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function addDriverTips(Request $request)
    {
        if (booking::whereId($request->bookingId)->exists())
        {
            $booking = booking::whereId($request->bookingId)->first();
            if (passengers::whereId($booking->userid)->exists())
            {
                booking::whereId($request->bookingId)->update(['driver_tips	'=>$request->driverTips]);
                $booking = booking::whereId($request->bookingId)->first();
                if ($booking->image != '' || !empty($booking->image))
                {
                    $booking->image = asset('public/avatars').'/'.$booking->image;
                }
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "Tips added Succeessfully";
                $response['data'] = $booking;
            }
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "User Not Found";
            $response['data'] = [];
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "Booking Not Found";
            $response['data'] = [];
        }
        return $response;
    }


//**********************************************************************************************************************




//*************************************************User Driver Relationships********************************************

    public function favouriteDriver($userid)
    {
        if (passengers::whereId($userid)->exists())
        {
            $user = passengers::whereId($userid)->first();
            if (favDriver::where('userid',$user->id)->exists())
            {
                $drivers = DB::select("select d.* from drivers d,fav_drivers c where d.id=c.driverid and c.userid=$userid and d.deleted_at is null and c.deleted_at is null");
                foreach ($drivers as $driver) {
                    if ($driver->image != '' || !empty($driver->image))
                    {
                        $driver->image = asset('public/avatars').'/'.$driver->image;
                    }
                }
                $favourite = favDriver::where('userid',$user->id)->get();
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "User Favourite Driver";
                $response['data'] = $drivers;
            }
            else
            {
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "User Favourite Driver List is Empty!";
                $response['data'] = [];
            }
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "User Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function addFavourite(Request $request)
    {
        $mNumber = $request->phone;
        if (passengers::where('phone',$mNumber)->exists())
        {
            $user = passengers::where('phone',$mNumber)->first();
            if (driver::whereId($request->driverid)->exists())
            {
                $fav=favDriver::create([
                    'userid'=>$user->id,
                    'driverid'=>$request->driverid
                ]);
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "User Favourite Created Successfully!";
                $response['data'] = $fav;
            }
            else
            {
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['Message'] = "Driver Not Found";
                $response['data'] = [];
            }
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "User Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function deleteFavourite(Request $request)
    {
        if (favDriver::whereId($request->favouriteId)->exists())
        {
            $fav = favDriver::whereId($request->favouriteId)->delete();
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['Message'] = "User Favourite Deleted Successfully!";
            $response['data'] = $fav;
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "Favourite Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function driverDetail(Request $request)
    {
        if (driver::whereId($request->driverid)->exists())
        {
            $driver = driver::whereId($request->driverid)->first();
            if ($driver->image != '' || !empty($driver->image))
            {
                $driver->image = asset('public/avatars').'/'.$driver->image;
            }
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['Message'] = "Driver Detail Fetched Successfully!";
            $response['data'] = $driver;
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "Driver Not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function driverTips(Request $request)
    {
        if (driver::whereId($request->driverid)->exists())
        {
            if (booking::where('driverid',$request->driverid)->exists())
            {
                $drivertips = booking::where('driverid',$request->driverid)->get();
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "Tips fetched Succeessfully";
                $response['data'] = $drivertips;
            }
            else
            {
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "Driver Tips are Empty!";
                $response['data'] = [];
            }
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "Driver Not Found";
            $response['data'] = [];
        }
        return $response;
    }

//**********************************************************************************************************************




//*********88888888888************************User invite's friends*****************************************************

    public function inviteFriends(Request $request)
    {
        $numbers  = explode(',',$request->mobile_numbers);
        $error = [];
        $invitationid = time().rand(1,5698742);
        foreach ($numbers as $number)
        {
            $number1 = str_replace(' ','',$number);
            $message = "I switched to ChauffeurX. It’s awesome!!! You should download it today";
            $sid    = "AC7835895b4de3218265df779b550d793b";
            $token  = "c44245d2f7d682f18eb3a1399d8d5ef6";
            $twilio = new Client($sid, $token);

            try
            {
                $text = $twilio->messages
                    ->create($number1, // to
                        array("from" => "+19562759175",
                            "body" => $message
                        )
                    );
                $input['phone'] = $number1;
                $input['date'] = new \DateTime();
                $input['invite_id'] = $invitationid;
                invitedFriends::create($input);
            }
            catch (RestException $ex)
            {
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['message'] = "Invitation send Failed";
                $response['data'] = $ex->getMessage();
                $response['mobile_number'] = $number;
                array_push($error,$response);
                invitedFriends::where('phone',$number)->where('invite_id',$invitationid)->forcedelete();
//                $error['response'] .= $response;
            }

        }
        if ($error == '' || empty($error))
        {
            $invited_users = invitedFriends::where('invite_id',$invitationid)->get();
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "Invitation sent Succesfully";
            $response['data'] = $invited_users;
            return $response;
        }
        else
        {
            $error['status'] = "Failed";
            $error['code'] = 500;
            $error['message'] = "Invitation send Failed";
            return $error;
        }
    }
    public function inviteFriends1(Request $request)
    {
        $userid = $request->userid;
        $referralCode = $request->code;
        $numbers  = explode(',',$request->mobile_numbers);
        $error = [];
        $invitationid = time().rand(1,5698742);
        foreach ($numbers as $number)
        {
            $number1 = str_replace(' ','',$number);
            $message = "I switched to ChauffeurX. It’s awesome!!! You should download it today";
            $sid    = "AC7835895b4de3218265df779b550d793b";
            $token  = "c44245d2f7d682f18eb3a1399d8d5ef6";
            $twilio = new Client($sid, $token);

            try
            {
                $text = $twilio->messages
                    ->create($number1, // to
                        array("from" => "+19562759175",
                            "body" => $message
                        )
                    );
                $input['phone'] = $number1;
                $input['date'] = new \DateTime();
                $input['invite_id'] = $invitationid;
                $input['invitee'] = $userid;
                $input['code'] = $referralCode;
                invitedFriends::create($input);
            }
            catch (RestException $ex)
            {
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['message'] = "Invitation send Failed";
                $response['data'] = $ex->getMessage();
                $response['mobile_number'] = $number;
                array_push($error,$response);
                invitedFriends::where('phone',$number)->where('invite_id',$invitationid)->forcedelete();
//                $error['response'] .= $response;
            }

        }
        if ($error == '' || empty($error))
        {
            $invited_users = invitedFriends::where('invite_id',$invitationid)->get();
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "Invitation sent Succesfully";
            $response['data'] = $invited_users;
            return $response;
        }
        else
        {
            $error['status'] = "Failed";
            $error['code'] = 500;
            $error['message'] = "Invitation send Failed";
            return $error;
        }
    }

//**********************************************************************************************************************


//***********************************************advertisements ************************************************

    function advertisement(Request $request)
    {
        $input = $request->except('image');
        if($request->hasFile('image'))
        {
            $photoName = rand(1, 777777777) . time() . '.' . $request->image->getClientOriginalExtension();
            $mime = $request->image->getClientOriginalExtension();
            $request->image->move(public_path('avatars'), $photoName);
            $input['image'] = $photoName;
        }
        $ads = advertisement::create($input);
        if ($ads->image != '' || !empty($ads->image))
        {
            $ads->image = asset('public/avatars').'/'.$ads->image;
        }
        $response['status'] = "Success";
        $response['code'] = 200;
        $response['Message'] = "Ads saved Successfully";
        $response['data'] = $ads;
        return $response;
    }

//    ***************************************************************************************************************


//**********************************************************Some global functions **************************************
    function compress($source, $destination, $quality,$mime) {
// Set a maximum height and width
        $width = 200;
        $height = 200;

// Content type
        header('Content-Type: image/'.$mime);

// Get new dimensions
        list($width_orig, $height_orig) = \getimagesize($source);

        $ratio_orig = $width_orig/$height_orig;

        if ($width/$height > $ratio_orig) {
            $width = $height*$ratio_orig;
        } else {
            $height = $width/$ratio_orig;
        }

// Resample
        $image_p = \imagecreatetruecolor($width, $height);
        $info = \getimagesize($source);

        if ($info['mime'] == 'image/jpg')
            $image = \imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/jpeg')
            $image = \imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = \imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = \imagecreatefrompng($source);


//            $image = \imagecreatefromjpeg($filename);
        \imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

// Output
        \imagejpeg($image_p, $destination, $quality);
        return $destination;
    }

    function UnlinkImage($filepath)
    {
        $old_image = $filepath;
        if (file_exists($old_image)) {
            @unlink($old_image);
        }
    }

    function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$lon1."&destinations=".$lat2.",".$lon2."&key=$this->googleMap";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        $dist = $response_a['rows'][0]['elements'][0]['distance']['value']/1000;
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
        $mins = round(($response_a['rows'][0]['elements'][0]['duration']['value'])/60);

        return array('distance' => $dist, 'time' => $time ,'city' => $this->getAddress($lat1,$lon1),'min' => $mins);
    }

    function calculatePrice($category,$distance)
    {
        $categoryPrice = price::where('category',$category)->first();
        $categoryPerKM = $categoryPrice->amount;
        $price = $distance*$categoryPerKM;
        return $price;
    }

    function getAddress($lat,$lon)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lon&key=$this->googleMap";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
//        return $response;
        curl_close($ch);
        $response_a = json_decode($response, true);
//        return $response_a;

        foreach ($response_a['results'][0]['address_components'] as $address)
        {
           if ($address['types'][0] == 'locality')
           {
               $city = $address['long_name'];
               break;
           }
           elseif ($address['types'][0] == 'administrative_area_level_2')
           {
               $city = $address['long_name'];
               break;
           }
           elseif ($address['types'][0] == 'administrative_area_level_1')
           {
               $city = $address['long_name'];
               break;
           }
        }
        return $city;

//        return $response_a['results'][0]['address_components'];
    }

    function fetchNearbyDrivers($drivers,$lat1,$long1)
    {
        $driverLatLng = [];
        foreach ($drivers as $driver)
        {
//            $coordinates=$this->database->getReference('users')->getChild($driver->device_token)->getValue();
            $coordinates=$this->database->getReference('online_drivers')->getChild($driver->device_token)->getValue();
            if (empty($coordinates['driverId']) || empty($coordinates['lat']) || empty($coordinates['lng']))
            {
                continue;
            }
            $coordinates['driverid'] = $driver->id;
            array_push($driverLatLng,$coordinates);
        }
        foreach ($driverLatLng as $driver)
        {
            $id = $driver['driverid'];
            $lat2 = $driver['lat'];
            $long2 = $driver['lng'];
            if (driver::whereId($id)->exists() == 0)
            {
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['message'] = "Driver with id = $id not Found";
                $response['data'] = [];
                return $response;
            }
            if (isset($lat1) && isset($long1) && isset($lat2) && isset($long2))
            {
                $Totaldistance = $this->calculateDistance($lat1,$long1,$lat2,$long2);
                if (DB::table('maximum_distance')->exists())
                {
                    $max_distance = DB::table('maximum_distance')->first();
                    $max_distance = (float)$max_distance->distance;
                }
                else
                {
                    $max_distance = 10;
                }
                if ((float)$Totaldistance['distance'] <= (float)$max_distance)
                {
                    $distance[$id] = $Totaldistance['distance'];
                    $array['lat'] = $lat2;
                    $array['long'] = $long2;
                    $array['driverid'] = $id;
                    $array['driverId'] = $driver['driverId'];
                    $latLng[$id] = $array;
                }
            }
        }
        if (isset($distance) && ($distance != '' || !empty($distance)))
        {
            asort($distance);
            if (count($distance) > 0)
            {
                $output = array_slice($distance,0,10,true);
            }
            else {
                $output = $distance;
            }
            $nearbyDriver = [];
            foreach ($output as $key => $value)
            {
                array_push($nearbyDriver,$latLng[$key]);
            }
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "Nearby drievrs are fetched successfully!";
            $response['data'] = $nearbyDriver;
            return $response;
        }
        else
        {
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "No nearby drivers are found!";
            $response['data'] = [];
            return $response;
        }
    }

    function driverByCategory($categoryid)
    {
        $drivers = DB::select("select d.* from drivers d,driver_categories c where d.id=c.driverid and c.categoryid=$categoryid and d.deleted_at is null and c.deleted_at is null and d.isAvailable = 1");
        return $drivers;
    }

    public function pushNotification($title,$body, $token,$driver)
    {
        $push = new PushNotification('fcm');
        $push->setMessage( [
            'aps' => [
                'alert' => [
                    'title' => $title,
                    'body'  => $driver->name . $body,
                    'pushFor' => 'accept'
                ],
                'sound' => 'default',
                'badge' => 1

            ]
        ] )
            ->setDevicesToken( $token )
            ->send();
    }

//**********************************************************************************************************************


    public function whatsappDemo()
    {
        $message = "Im just trying for the Whatsapp Demo using Twilio. Thank u have a nice day!!";
        $sid    = "AC465cbf46932d06fcc92a3b6b018dc484";
        $token  = "90cbd07cf0f887ce8a7d96e81f652945";
        $twilio = new Client($sid, $token);

        try
        {
            $message = $twilio->messages
                ->create("whatsapp:+919591949175", // to
                    array(
                        "from" => "whatsapp:+14155238886",
                        "body" => $message
                    )
                );
        }
        catch (RestException $ex)
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Invitation send Failed";
            $response['data'] = $ex->getMessage();
            $response['mobile_number'] = +919591949175;
            return $response;
        }
        return $message;
    }
}
