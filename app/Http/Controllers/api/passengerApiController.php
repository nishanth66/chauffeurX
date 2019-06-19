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
use App\Models\notification;
use App\Models\passengers;
use App\Models\passengerStripe;
use App\Models\price;
use App\Models\rank;
use App\Models\rating;
use App\Models\template;
use App\Models\userCoupons;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Rest\Client;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Edujugon\PushNotification\PushNotification;
use \Carbon\Carbon;

class passengerApiController extends Controller
{
    protected $googleMap = "AIzaSyB56Xh1A7HQDPQg_7HxrPTcSNnlpqYavc0";
    private $database;
    protected $sid    = "sid";
    protected $token  = "token";
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
    public function deleteNotification(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "User could not be found";
            $response['data'] = [];
            return $response;
        }
        if (notification::exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Notification not Found";
            $response['data'] = [];
            return $response;
        }
        notification::where('userid',$request->userid)->forcedelete();
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Notification deleted successfully";
        $response['data'] = [];
        return $response;
    }
    public function login(Request $request)
    {
        $mNumber = $request->phone;
        if (passengers::where('phone',$mNumber)->where('activated',1)->exists())
        {
            $otp = substr(str_shuffle("0123456789"), 0, 4);
            $message = "Thanks for logging in ChauffeurX. Here's your verification code";
            $response = parent::sendOtp($this->sid,$this->token,$mNumber,$otp,$message);
            if ($response['code'] == 200)
            {
                $user = passengers::where('phone',$mNumber)->update(['otp' => $otp]);
            }
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This user doesn’t exist";
            $response['number'] = $mNumber;
            $response['data'] = [];
        }
        return $response;
    }

    public function verify(Request $request)
    {
        if (!isset($request->device_token) || !isset($request->device_type) || $request->device_token == '' || $request->device_type == '' || empty($request->device_type) || empty($request->device_token))
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Device token and Device type can not be empty!";
            $response['data'] = [];
            return $response;
        }
        if (passengers::where('phone',$request->phone)->where('otp',$request->otp)->exists())
        {
            $user = passengers::where('phone',$request->phone)->where('otp',$request->otp)->first();
            unset($user->password);
            passengers::whereId($user->id)->update(['device_token'=>$request->device_token,'device_type'=>$request->device_type,'activated'=>1]);
            if ($user->image != '' || !empty($user->image))
            {
                $user->image = asset('public/avatars').'/'.$user->image;
            }
                $response['status'] = "success";
                $response['code'] = 200;
                $response['message'] = "Great. Your phone number is verified!";
                $response['data'] = $user;

        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Verification code invalid";
            $response['data'] = [];
        }
        return $response;
    }

    public function changePhoneNumber(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
            return $response;
        }
        if (passengers::where('id','!=',$request->userid)->where('phone',$request->phone)->exists())
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This number is already attached to a customer";
            $response['data'] = [];
            return $response;
        }
        $mNumber = $request->phone;
        $otp = substr(str_shuffle("0123456789"), 0, 4);
        $message = "Your ChauffeurX verification code is";
        passengers::whereId($request->userid)->update(['new_phone' => $mNumber]);
        $response = parent::sendOtp($this->sid,$this->token,$mNumber,$otp,$message);
        if ($response['code'] == 200)
        {
            $user = passengers::whereId($request->userid)->update(['otp' => $otp]);
        }
        return $response;
    }

    public function verifyNewPhoneNumber(Request $request)
    {
        $mNumber = $request->phone;
        $otp = $request->otp;
        $userid = $request->userid;
        if (passengers::whereId($userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
            return $response;
        }
        if (passengers::whereId($userid)->where('new_phone',$mNumber)->where('otp',$otp)->exists())
        {
            passengers::whereId($userid)->update(['phone'=>$mNumber]);
            $user = passengers::whereId($userid)->first();
            unset($user->password);
            if ($user->image != '' || !empty($user->image))
            {
                $user->image = asset('public/avatars').'/'.$user->image;
            }
            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "New phone number saved";
            $response['data'] = $user;

            return $response;

        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Verification code invalid";
            $response['data'] = [];
            return $response;
        }
    }

    public function profile(Request $request)
    {
        if (!isset($request->phone) || empty($request->phone))
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Please enter the Phone number";
            $response['data'] = [];
            return $response;
        }
        $mNumber = $request->phone;
        if (passengers::where('id','!=',$request->userid)->where('phone',$mNumber)->exists()){
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This mobile number already used by other user.";
            $response['data'] = [];
            return $response;
        }
        if (passengers::where('id','!=',$request->userid)->where('email',$request->email)->exists())
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This email already used by other user.";
            $response['data'] = [];
            return $response;
        }
//        if (passengers::whereId($request->userid)->where('phone',$mNumber)->exists() == 0)
        if (passengers::whereId($request->userid)->exists() == 0)
        {
                $response['status'] = "failed";
                $response['code'] = 500;
                $response['message'] = "This user doesn’t exist";
                $response['data'] = [];
                return $response;
        }

        if (isset($request->password) && $request->password != $request->confirm_password)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Passwords don’t match";
            $response['data'] = [];
            return $response;
        }

            $update = $request->except('except','password','confirm_password','userid');
            if (isset($request->password) && $request->password != '')
            {
//                $update['password'] = Hash::make($request->password);
            }
            if($request->hasFile('image'))
            {
                $photoName = rand(1, 777777777) . time() . '.' . $request->image->getClientOriginalExtension();
                $mime = $request->image->getClientOriginalExtension();
                $request->image->move(public_path('avatars'), $photoName);
                $update['image'] = $photoName;
            }
//            passengers::whereId($request->userid)->where('phone',$mNumber)->update($update);
            passengers::whereId($request->userid)->update($update);
            $user = passengers::whereId($request->userid)->where('phone',$mNumber)->first();
            unset($user->password);
            if ($user->image != '' || !empty($user->image))
            {
                $user->image = asset('public/avatars').'/'.$user->image;
            }
            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Saved";
            $response['data'] = $user;

            $reference = $this->database->getReference('user');

            $postData[$user->firebase_key] = [
                'userid' => 'user_'.$user->id,
                'username'=> $user->fname,
                'usertype'=> 'user',
                'email' => $user->email,
                'message' => [
                    'idSender' => '',
                    'idReceiver' => '',
                    'text' => '',
                    'timestamp' => '',
                ],
                'status' => [
                    'isOnline' => true,
                    'timestamp' => ''
                ],
            ];
            $reference->update($postData);
//

        return $response;
    }

    public function userDetails(Request $request)
    {
        if (passengers::whereId($request->userid)->exists())
        {
            $user = passengers::whereId($request->userid)->first();
//            unset($user->password);
            if ($user->image != '' || !empty($user->image))
            {
                $user->image = asset('public/avatars').'/'.$user->image;
            }
            else
            {
                $user->image = "";
            }
            $user = $user->makeHidden(['remember_token','email_verified_at','otp','passengers']);
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "";
            $response['data'] = $user;
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
        }
        return $response;
    }

    public function register(Request $request)
    {
        $mNumber = $request->phone;
        if (passengers::where('phone',$mNumber)->where('activated',1)->exists())
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This number is already attached to a customer";
            $response['data'] = [];
            return $response;
        }
        elseif (passengers::where('email',$request->email)->where('activated',1)->exists())
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This email is already attached to a customer";
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
                        "body" => "Thanks for signing up with ChauffeurX. Here's your verification code: ".$otp
                    )
                );
        }
        catch (RestException $ex)
        {
            $response['status'] = 500;
            $response['message'] = "Failed to send the Verification Code";
            $response['data'] = $ex->getMessage();
            return $response;
        }
        if (passengers::where('phone',$mNumber)->where('email',$request->email)->where('activated',0)->exists())
        {
            $user = passengers::where('phone',$mNumber)->where('email',$request->email)->where('activated',0)->first();
            passengers::whereId($user->id)->update(['otp'=>$otp]);
            $user = passengers::whereId($user->id)->first();
        }
        else
        {
            $i=1;
            $j = 6;
            while($i != 0)
            {
                $string = "";
                for($i=0;$i < $j;$i++){
                    srand((double)microtime()*1234567);
                    $x = mt_rand(0,2);
                    switch($x){
                        case 0:$string.= chr(mt_rand(97,122));break;
                        case 1:$string.= chr(mt_rand(65,90));break;
                        case 2:$string.= chr(mt_rand(48,57));break;
                    }
                }
                if (passengers::where('referral_code','like',$string)->exists() || driver::where('referal_code','like',$string)->exists())
                {
                    if ($i > 999)
                    {
                        $j++;
                    }

                    $i=1;
                }
                else
                {
                    $i=0;
                    $user = passengers::create(['phone'=>$mNumber,'otp'=>$otp,'email'=>$request->email,'referral_code'=>$string]);
                }
            }
            $reference = $this->database->getReference('user');
            $postRef = $reference->push([
                'userid ' => 'user_'.$user->id,
                'usertype'=> 'user',
                'message' => [
                    'idSender' => '',
                    'idReceiver' => '',
                    'text' => '',
                    'timestamp' => '',
                ],
                'status' => [
                    'isOnline' => true,
                    'timestamp' => ''
                ]
            ]);
            $postKey = $postRef->getKey();
            $updateKey['firebase_key'] = $postKey;
            passengers::whereId($user->id)->update($updateKey);
        }
        if ($user->image != '' || !empty($user->image))
        {
            $user->image = asset('public/avatars').'/'.$user->image;
        }
        unset($user->password);
        $response['status'] = "success";
        $response['code'] = 200;
        $response['message'] = "Registered Successfully";
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
            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Profile Updated Successfully!";
            $response['data'] = [];
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
        }
        return $response;
    }

    public function addStripeCard(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This user doesn’t exist";
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
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Card Details are Missing";
            $response['data'] = [];
            return $response;
        }
        $user = passengers::whereId($request->userid)->first();
        try
        {
            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $request->get('card_no'),
                    'exp_month' => $request->get('ccExpiryMonth'),
                    'exp_year' => $request->get('ccExpiryYear'),
                    'cvc' => $request->get('cvvNumber'),
                ],
            ]);
        }
        catch(\Exception $e)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = $e->getMessage();
            $response['data'] = [];
            return $response;
        }

        if(empty($user->stripe_id)){
            try{
                $customer = $stripe->customers()->create([
                    'email' => $user->email,
                    'description' => 'Stripe Customer with user id -'.$user->id,
                ]);
            }
            catch(\Exception $e)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = $e->getMessage();
                $response['data'] = [];
                return $response;
            }
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
            try
            {
                $cards = $stripe->cards()->create($customerId, $token['id']);
            }
            catch(\Exception $e)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = $e->getMessage();
                $response['data'] = [];
                return $response;
            }
            $stripe_input['userid'] = $user->id;
            $stripe_input['brand'] = $token['card']['brand'];
            $stripe_input['customerId'] = $customerId;
            $stripe_input['cardNo'] = $cards['id'];
            $stripe_input['fingerprint'] = $stripe_fingerprint;
            $stripe_input['digits'] = 'XXXXXXXXXXXX'.$token['card']['last4'];
            $stripeCards = passengerStripe::create($stripe_input);

            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Stripe Cards Saved Successfully";
            $response['data'] = $stripeCards;
            return $response;
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This card is already Exists";
            $response['data'] = [];
            return $response;
        }

    }

    public function activateCard(Request $request)
    {
        if (passengers::whereId($request->userid)->exists()==0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This user doesn’t exist";
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
            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Card Activated Successfully";
            $response['data'] = $stripeCard;
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Card could not be Found";
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
                $response['status'] = "success";
                $response['code'] = 200;
                $response['message'] = "User Stripe cards have been Fetched successfully";
                $response['data'] = $cards;
            }
            else
            {
                $response['status'] = "success";
                $response['code'] = 200;
                $response['message'] = "User has no Srtipe Cards";
                $response['data'] = [];
            }
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
        }
        return $response;
    }

    public function getNotifications(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
            return $response;
        }
        if (notification::where('userid',$request->userid)->exists() == 0)
        {
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "No notifications are Found";
            $response['data'] = [];
            return $response;
        }
        $notifications = notification::where('userid',$request->userid)->orderby('id','desc')->get();
        foreach ($notifications as $notification)
        {
            if ($notification->image != '' || !empty($notification->image))
            {
                $notification->image = asset('public/avatars').'/'.$notification->image;
            }
        }
        $user = $notifications->makeHidden(['updated_at','deleted_at','title']);
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Notifications fetched Successfully";
        $response['data'] = $notifications;
        return $response;
    }

    public function readNotification(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be Found";
            $response['data'] = [];
            return $response;
        }
        if (notification::whereId($request->notification_id)->where('userid',$request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Notification could not be Found";
            $response['data'] = [];
            return $response;
        }
        notification::whereId($request->notification_id)->update(['read',1]);
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Notification updated successfully";
        $response['data'] = [];
        return $response;
    }

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
                $response['status'] = "failed";
                $response['code'] = 500;
                $response['message'] = "Failed to send the Invitation";
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
            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Invitation sent Succesfully";
            $response['data'] = $invited_users;
            return $response;
        }
        else
        {
            $error['status'] = "failed";
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
                $response['status'] = "failed";
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
            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Invitation sent Succesfully";
            $response['data'] = $invited_users;
            return $response;
        }
        else
        {
            $error['status'] = "failed";
            $error['code'] = 500;
            $error['message'] = "Invitation send Failed";
            return $error;
        }
    }

    public function discountAvailable(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['messgae'] = "This user doesn’t exist";
            $response['data'] = [];
            return $response;
        }
        $user = passengers::whereId($request->userid)->first();
        $ranks = rank::get();
        $coins = (float)$user->coins;
        $user = $this->calculateRank($ranks,$coins,$user);
        $user = passengers::whereId($user->id)->first();
        if ($user->rankid != 0)
        {
            $rank = rank::whereId($user->rankid)->first(['discount']);
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "Discount Fetched Successfully";
            $response['discount_available'] = 1;
            $response['discount'] = $rank->discount;
            return $response;
        }
        else
        {
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "Discount not available";
            $response['discount_available'] = 0;
            $response['discount'] = 0;
            return $response;
        }
    }

    public function sendPush($id)
    {
        $user = passengers::whereId($id)->first();
        $booking = booking::whereId(26)->first();
        $riderDetails = driver::whereId(38)->first();
        $title = "Booking Verification Code";
        $pushFor = "Booking Verification Code";
        $token = (string)$user->device_token;
        $body['username'] = $user->fname.' '.$user->lname;
        $body['booking_id'] = $booking->id;
        $body['driver_id'] = $booking->driverid;
        $body['driver_name'] = $riderDetails->first_name.' '.$riderDetails->middle_name.' '.$riderDetails->last_name;
        $body['driver_email'] = $riderDetails->email;
        $body['driver_phone'] = $riderDetails->code.$riderDetails->phone;
        $body['driver_rating'] = app('App\Http\Controllers\api\driverApiController')->driverRating($riderDetails->id);
        $body['userid'] = $booking->userid;
        $body['phone'] = $booking->phone;
        $body['source'] = $booking->source;
        $body['destination'] = $booking->destination;
        $body['original_price'] = $booking->original_price;
        $body['price'] = $booking->price;
        $body['distance'] = $booking->distance;
        $body['estimated_time'] = $booking->estimated_time;
        $body['booking_otp'] = $booking->otp;
        $msg = "Ride Request";
        $body['message'] = $msg;
        $UserpushNotification = parent::pushNotification($title,$body,$token,$user,$pushFor,$msg,1);


            echo '<pre>';
            print_r($UserpushNotification);

    }


    function calculateRank($ranks,$coins,$user)
    {
        foreach ($ranks as $rank)
        {
            $requiredCoin = (float)$rank->points;
            if (rank::whereId($rank->id +1)->exists())
            {
                $nextRank = rank::whereId($rank->id +1)->first();
                $nextCoin = (float)$nextRank->points;
                if ($coins >= $requiredCoin && $coins < $nextCoin)
                {
                    $update['rankid'] = $rank->id;
                    passengers::whereId($user->id)->update($update);
                }
            }
            elseif($coins >= $requiredCoin)
            {
                $update['rankid'] = $rank->id;
                passengers::whereId($user->id)->update($update);
            }
        }
        $user = passengers::whereId($user->id)->first();
        return $user;
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
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Invitation send Failed";
            $response['data'] = $ex->getMessage();
            $response['mobile_number'] = +919591949175;
            return $response;
        }
        return $message;
    }
    public function logout(Request $request)
    {
        if (passengers::whereId($request->userid)->exists())
        {
            passengers::whereId($request->userid)->update(['device_token'=>null]);
            $user = passengers::whereId($request->userid)->first();
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "User logged out successfully";
            $response['data'] = $user;
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
        }
        return $response;
    }

    public function refreshDeviceToken(Request $request)
    {
        if (passengers::whereId($request->userid)->exists())
        {
            passengers::whereId($request->userid)->update(['device_token'=>$request->device_token,'device_type'=>$request->device_type]);
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "Token Updated Successfully";
            $response['data'] = [];
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
        }
        return $response;
    }

    public function userRank(Request $request)
    {
        if (passengers::whereId($request->userid)->exists())
        {
            $user = passengers::whereId($request->userid)->first();
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "User rank and Poins";
            if ($user->rankid != 0)
            {
                $rankDetails = rank::whereId($user->rankid)->first();
                $response['rank_name'] = $rankDetails->name;
            }
            else
            {
                $response['rank_name'] = "";
            }
            $response['user_points'] = $user->coins;
            $response['data'] = [];
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "User doesn't exists";
            $response['data'] = [];
        }
        return $response;
    }
}
