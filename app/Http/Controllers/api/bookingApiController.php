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

class bookingApiController extends Controller
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

        $firebase = (new Factory())
            ->withServiceAccount($serviceAccount)
            ->create();


        $this->database = $firebase->getDatabase();
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

    public function sendBookingOtp(Request $request)
    {
        if (booking::whereId($request->bookingid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "success";
            $response['message'] = "Booking not found";
            $response['data'] = [];
            return $response;
        }
        $booking = booking::whereId($request->bookingid)->first(['phone']);
        $mNumber = $booking->phone;
        $otp = substr(str_shuffle("0123456789"), 0, 4);
        $response = parent::sendOtp($this->sid,$this->token,$mNumber,$otp);
        if ($response['code'] == 200)
        {
            booking::whereId($request->bookingid)->update(['otp'=>$otp]);
        }
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

    public function displayPriceOld(Request $request)
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
    public function displayPrice(Request $request)
    {
        if (passengers::whereId($request->userid)->where('phone',$request->phone)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status']     = 'failed';
            $response['message']    = 'User not found';
            $response['data']    = [];
        }
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

        if (categories::exists() == 0)
        {
            $response['code'] = 500;
            $response['status']     = 'failed';
            $response['message']    = 'Admin didnt setup any Category';
            $response['data']    = [];
        }
        $userDetais = explode('-',$request->user_lat_lng);
        if ((!isset($userDetais[0]) || $userDetais[0] == '' || empty($userDetais[0])) || (!isset($userDetais[1]) || $userDetais[1] == '' ||  empty($userDetais[1])))
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Invalid user data Received! Format- user_lat_lng = 'lat-lng'";
            $response['data'] = [];
            return $response;
        }
        if (!isset($request->payment_method_id) || $request->payment_method_id == '' || empty($request->payment_method_id))
        {
            $drivers=$this->getDriver($request->discount,$request->favoriteDriver,$request->userid);

            if ($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 0)
            {
                $response['code'] = 500;
                $response['status'] = "Failed";
                $response['message'] = "No Favorite Drivers are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;
            }
            elseif($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 1)
            {
                $response['code'] = 500;
                $response['status'] = "Failed";
                $response['message'] = "No Favorite Drivers with Offering Discount are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;

            }
            elseif (count($drivers) < 1)
            {
                $response['code'] = 500;
                $response['status'] = "Failed";
                $response['message'] = "No Drivers are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;
            }
        }
        else
        {
            $drivers=$this->getDriver($request->discount,$request->favoriteDriver,$request->userid,$request->payment_method_id);

            if ($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 0)
            {
                $response['code'] = 500;
                $response['status'] = "Failed";
                $response['message'] = "No Favorite Drivers are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;

            }
            elseif($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 1)
            {
                $response['code'] = 500;
                $response['status'] = "Failed";
                $response['message'] = "No Favorite Drivers with Offering Discount are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;

            }
            elseif (count($drivers) < 1)
            {
                $response['code'] = 500;
                $response['status'] = "Failed";
                $response['message'] = "No Drivers are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;
            }
        }
        $latSrc = $userDetais[0];
        $lonSrc = $userDetais[1];
        $responseDriver=app('App\Http\Controllers\api\bookingDriverApiController')->fetchNearbyDrivers($drivers,$latSrc,$lonSrc);
        $drivers = $responseDriver['data'];

        $fetchedDrivers = $this->getFilteredDriver($drivers,$request,$distanceTime);
        return $fetchedDrivers;


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


    public function booking(Request $request)
    {
//        return $request->all();
        if (passengers::whereId($request->userid)->where('phone',$request->phone)->exists())
        {
            $input = $request->except('image','discount');
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

            $userDetais = explode('-',$request->user_lat_lng);
            if ((!isset($userDetais[0]) || $userDetais[0] == '' || empty($userDetais[0])) || (!isset($userDetais[1]) || $userDetais[1] == '' ||  empty($userDetais[1])))
            {
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['message'] = "Invalid user data Received! Format- user_lat_lng = 'lat-lng'";
                $response['data'] = [];
                return $response;
            }

            $lat1 = $userDetais[0];
            $long1 = $userDetais[1];
            if (isset($request->payment_method_id)  && $request->payment_method_id != '' || !empty($request->payment_method_id))
            {
                if (DB::table('payment_methods')->whereId($request->payment_method_id)->exists() == 0)
                {
                    $response['status'] = "Failed";
                    $response['code'] = 500;
                    $response['message'] = "This payment method is not Accepted";
                    $response['data'] = [];
                    return $response;
                }
                $drivers=app('App\Http\Controllers\api\bookingDriverApiController')->driverByCategory($request->categoryId,$request->favoriteDriver,$request->discount,$request->userid,$request->payment_method_id);
                $input['payment_method'] = $request->payment_method_id;
                if ($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 0)
                {
                    $response['code'] = 500;
                    $response['status'] = "Failed";
                    $response['message'] = "No Favorite Drivers are Found!";
                    $response['favorite_driver_filter'] = 0;
                    $response['discount_available_filter'] = 0;
                    $response['data'] = [];
                    return $response;
                }
                elseif($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 1)
                {
                    $response['code'] = 500;
                    $response['status'] = "Failed";
                    $response['message'] = "No Favorite Drivers with Offering Discount are Found!";
                    $response['favorite_driver_filter'] = 0;
                    $response['discount_available_filter'] = 0;
                    $response['data'] = [];
                    return $response;

                }
                elseif (count($drivers) < 1)
                {
                    $response['code'] = 500;
                    $response['status'] = "Failed";
                    $response['message'] = "No Drivers are Found!";
                    $response['favorite_driver_filter'] = 0;
                    $response['discount_available_filter'] = 0;
                    $response['data'] = [];
                    return $response;
                }
            }
            else
            {
                $drivers=app('App\Http\Controllers\api\bookingDriverApiController')->driverByCategory($request->categoryId,$request->favoriteDriver,$request->discount,$request->userid);
                if ($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 0)
                {
                    $response['code'] = 500;
                    $response['status'] = "Failed";
                    $response['message'] = "No Favorite Drivers are Found!";
                    $response['favorite_driver_filter'] = 0;
                    $response['discount_available_filter'] = 0;
                    $response['data'] = [];
                    return $response;
                }
                elseif($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 1)
                {
                    $response['code'] = 500;
                    $response['status'] = "Failed";
                    $response['message'] = "No Favorite Drivers with Offering Discount are Found!";
                    $response['favorite_driver_filter'] = 0;
                    $response['discount_available_filter'] = 0;
                    $response['data'] = [];
                    return $response;

                }
                elseif (count($drivers) < 1)
                {
                    $response['code'] = 500;
                    $response['status'] = "Failed";
                    $response['message'] = "No Drivers are Found!";
                    $response['favorite_driver_filter'] = 0;
                    $response['discount_available_filter'] = 0;
                    $response['data'] = [];
                    return $response;
                }
            }
//            $response = $this->fetchNearbyDrivers($drivers,$lat1,$long1);
            $response=app('App\Http\Controllers\api\bookingDriverApiController')->fetchNearbyDrivers($drivers,$lat1,$long1);
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
                if (driver::whereId($driver['driverid'])->where('isAvailable',1)->where('status',1)->exists())
                {
                    $driverid = $driver['driverid'];
                    $score[$driverid] = app('App\Http\Controllers\api\bookingDriverApiController')->assignDriver($driverid,$lat1,$long1);
                }
            }
            if (isset($score) && count($score) > 0)
            {
                $driverid = array_search(max($score),$score);
                $driver_score = max($score);
//                ******************* Push notification ********************
//                                    Code to push notification
//                $input['driverid'] = $driverid;
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

            if ($booking->image != '' || !empty($booking->image))
            {
                $booking->image = asset('public/avatars').'/'.$booking->image;
            }
            if (template::where('type','system')->where('title','Booking Confirm')->exists())
            {
                $template = template::where('type','system')->where('title','Booking Confirm')->first();
                $message = str_replace('xxx',$booking->id,$template->message);
                $notification['message'] = $message;
                $notification['image'] = $template->image;
            }
            else
            {
                $notification['message'] = "Your Booking #".$booking->id." is Successfull";
            }
            $notification['userid'] = $request->userid;
            $notification['type'] = "System";
            notification::create($notification);

            $response['status'] = "Success";
            $response['code'] = 200;
            $response['favorite_driver'] = $request->favoriteDriver;
            $response['message'] = "Booking Saved Successfully!";
            $response['data'] = $booking;
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "User Not Found";
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
        $now = time();
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
            $booking = booking::whereId($request->bookingid)->where('userid',$request->userid)->where('cancelled_at',null)->orWhere('cancelled_at','')->first();
            $then = strtotime($booking->created_at);
            $totalTime = ($now-$then)/60;

            if (cencellation::exists())
            {
                $cancellTime = cencellation::first();
                $totalMin = (float)$cancellTime->max_time;
                $totalPrice = (float)$cancellTime->amount;
            }
            else
            {
                $totalMin=1;
                $totalPrice=0;
            }
            if ($totalTime > $totalMin && $totalPrice > 0)
            {
                $response['code'] = 400;
                $response['success'] = "Failed";
                $response['message'] = "Cancellation time is exceeded";
                $response['cancellation_fee'] = $totalPrice;
                $response['data'] = [];
                return $response;
            }

            $updateBooking['status'] = "cancelled";
            $updateBooking['cancelled_at'] = new \DateTime();
            $updateBooking['cancelled_by'] = "user";
            booking::whereId($request->bookingid)->update($updateBooking);

            if (template::where('type','system')->where('title','Booking Cancel')->exists())
            {
                $template = template::where('type','system')->where('title','Booking Cancel')->first();
                $message = str_replace('xxx',$booking->id,$template->message);
                $notification['message'] = $message;
                $notification['image'] = $template->image;
            }
            else
            {
                $notification['message'] = "Your Booking #".$booking->id." is Cancelled";
            }
            $notification['userid'] = $request->userid;
            $notification['type'] = "System";
            notification::create($notification);

            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "Booking Cancelled Successfully!";
            $response['data'] = booking::whereId($request->bookingid)->first();
            return $response;
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Booking is already Cancelled";
            $request['data'] = [];
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
                'rating'=>$request->rating,
                'comments'=>$request->comments,
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

    public function rideHistory(Request $request)
    {
        $userid = $request->userid;
        $toDate = strtotime(str_replace('/','-',$request->date));
        if (passengers::whereId($userid)->exists() == 0)
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "User Not Found";
            $response['data'] = [];
            return $response;
        }
        if (booking::where('userid',$userid)->exists() ==0)
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['Message'] = "User have not booked any ride till now";
            $response['data'] = [];
            return $response;
        }
        $bookings = booking::where('userid',$userid)->get();
        $myBookings= [];
        foreach ($bookings as $booking)
        {
            $date = $booking->created_at;
            $tripDate = strtotime($date);
            $tripDate = strtotime(date('d-m-Y',$tripDate));
            if ($toDate == $tripDate)
            {
                $source = explode(',',$booking->source);
                $destination = explode(',',$booking->destination);
                $bookinDetailData['id'] = $booking->id;
                $bookinDetailData['userid'] = $booking->userid;
                $bookinDetailData['phone'] = $booking->phone;
                $bookinDetailData['driverid'] = $booking->driverid;
                $bookinDetailData['categoryId'] = $booking->categoryId;
                $bookinDetailData['completed'] = $booking->completed;
                $bookinDetailData['source'] = $booking->source;
                $bookinDetailData['destination'] = $booking->destination;
                $bookinDetailData['source_address'] = $this->getFormattedAddress($source[0],$source[1]);
                $bookinDetailData['destination_address'] = $this->getFormattedAddress($destination[0],$destination[1]);
                $bookinDetailData['price'] = $booking->price;
                $bookinDetailData['original_price'] = $booking->original_price;
                $bookinDetailData['distance'] = $booking->distance;
                $bookinDetailData['status'] = $booking->status;
                $bookinDetailData['paid'] = $booking->paid;
                $bookinDetailData['driver_tips'] = $booking->driver_tips;
                $bookinDetailData['trip_start_time'] = $booking->trip_start_time;
                $bookinDetailData['trip_end_time'] = $booking->trip_end_time;
                $bookinDetailData['cancelled_at'] = $booking->cancelled_at;
                $bookinDetailData['created_at'] = $booking->created_at;
                array_push($myBookings,$bookinDetailData);
            }
        }
        if (empty($myBookings) || count($myBookings) < 1)
        {
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "No Bookings are found on that day";
            $response['data'] = [];
            return $response;
        }
        $response['status'] = "Success";
        $response['code'] = 200;
        $response['message'] = "Driver Bookings fetched Successfully";
        $response['data'] = $myBookings;
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

    public function fetchNearbyAds(Request $request)
    {
        if (!isset($request->lat) || ($request->lat == '' || empty($request->lat)))
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Destination latitude can not be empty";
            $response['data'] = [];
            return $response;
        }
        if (!isset($request->lng) || ($request->lng == '' || empty($request->lng)))
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Destination longitude can not be empty";
            $response['data'] = [];
            return $response;
        }
        if(DB::table('maximum_distance')->exists())
        {
            $max = DB::table('maximum_distance')->first();
            if ($max->ads == '' || $max->ads == null || empty($max->ads) || $max->ads == 0)
            {
                $maxDistance = 10;
            }
            else
            {
                $maxDistance = $max->ads;
            }
        }
        else
        {
            $maxDistance = 10;
        }
        $ads = advertisement::get();
        if (count($ads) < 1)
        {
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "No advertisements Found";
            $response['data'] = [];
            return $response;
        }
        $lat1 = $request->lat;
        $long1 = $request->lng;
        $totalAds = [];
        foreach ($ads as $ad)
        {
            if (isset($ad->image) || ($ad->image != '') || !empty($ad->image))
            {
                $ad->image = asset('public/avatars').'/'.$ad->image;
            }
            $id = $ad->id;
            $lat2 = $ad->lat;
            $long2 = $ad->lng;
            $distance = $this->calculateDistance($lat1,$long1,$lat2,$long2);
            if ($distance['distance'] > $maxDistance)
            {
                continue;
            }
            else
            {
                array_push($totalAds,$ad);
            }
        }
        if (count($totalAds) < 1)
        {
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "No advertisements Found";
            $response['data'] = [];
        }
        else
        {
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "Advertisements fetched successfully";
            $response['data'] = $totalAds;
        }
        return $response;
    }

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

    function getFormattedAddress($lat,$lon)
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
        return $response_a['results'][0]['formatted_address'];

//        return $response_a['results'][0]['address_components'];
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

    function getDriver($discount,$favorite,$userid,$payment=null)
    {
        if ($discount == 0)
        {
            $drivers = driver::where('status',1)->where('isAvailable',1)->get();
        }
        else
        {
            $drivers = driver::where('status',1)->where('isAvailable',1)->where('discount','!=',0)->orderby('discount','desc')->get();
        }

        if($payment != null && $favorite == 0)
        {
            $payments = DB::table('driver_payment_method')->where('payment_method_id',$payment)->get();
            $paymentDrivers = [];
            foreach ($payments as $payment)
            {
                foreach ($drivers as $driver)
                {
                    if ($driver->id == $payment->driverid)
                    {
                        array_push($paymentDrivers,$driver);
                        break;
                    }
                }
            }
            return $paymentDrivers;
        }
        elseif (($payment == null || $payment == '') && $favorite == 1)
        {
            $all_driver = [];
            $favDrivers = favDriver::where('userid',$userid)->get();
            foreach ($favDrivers as $fav)
            {
                foreach ($drivers as $driver)
                {
                    if ($driver->id == $fav->driverid)
                    {
                        array_push($all_driver,$driver);
                        break;
                    }
                }
            }
            return $all_driver;
        }
        elseif (($payment != null || $payment != '') && $favorite == 1)
        {
            $paymentDrivers = DB::table('driver_payment_method')->where('payment_method_id',$payment)->get();
            $favDrivers = favDriver::where('userid',$userid)->get();
            $drivers = [];
            foreach ($paymentDrivers as $pay)
            {
                foreach ($favDrivers as $fav)
                {
                    if ($fav->driverid == $pay->driverid)
                    {
                        if ($discount == 0)
                        {
                            $driverDetail = driver::whereId($pay->driverid)->where('status',1)->first();
                        }
                        else
                        {
                            $driverDetail = driver::whereId($pay->driverid)->where('status',1)->where('discount','!=',0)->first();
                        }
                        if (isset($driverDetail) && !empty($driverDetail))
                        {
                            array_push($drivers,$driverDetail);
                            break;
                        }
                    }
                }
            }
            return $drivers;
        }
        return $drivers;
    }

    function getFilteredDriver($drivers,$request,$distanceTime)
    {
        $totalDistance = $distanceTime['distance'];
        $userDetais = explode('-',$request->user_lat_lng);
        $latSrc = $userDetais[0];
        $lonSrc = $userDetais[1];
        $driverDetails = [];
        foreach ($drivers as $driver)
        {
            $latDest = $driver['lat'];
            $lonDest = $driver['long'];
            $distanceTime = $this->calculateDistance($latSrc,$lonSrc,$latDest,$lonDest);
            if(driverCategory::where('driverid',$driver['driverid'])->exists())
            {
                $driverCategories = driverCategory::where('driverid',$driver['driverid'])->first(['categoryid']);
                $fetchDetails['driverid'] = $driver['driverid'];
                $fetchDetails['estimated_distance'] = $distanceTime['distance'];
                $fetchDetails['estimated_time'] = $distanceTime['time'];
                $fetchDetails['min'] = $distanceTime['min'];
                if ($request->discount == 1)
                {
                    $fetchDetails['discount'] = $driver['discount'];
                    $fetchDetails['discount_filter_applied'] = 1;
                }
                else
                {
                    $fetchDetails['discount_filter_applied'] = 0;
                }
                if ($request->favoriteDriver == 1)
                {
                    $fetchDetails['favorite_driver_filter_applied'] = 1;
                }
                else
                {
                    $fetchDetails['favorite_driver_filter_applied'] = 0;
                }
                $fetchDetails['category'] = $driverCategories->categoryid;
                $distanceDriver[$fetchDetails['driverid']] = $fetchDetails['min'];
                array_push($driverDetails,$fetchDetails);
            }
            else
            {
                continue;
            }

        }
        $categories = categories::get();
        $i=0;
        while($i < count($driverDetails))
        {
            foreach ($categories as $category)
            {
                if ($driverDetails[$i]['category'] == $category->id)
                {
                    $min = $driverDetails[$i];
                    foreach ($driverDetails as $driver)
                    {
                        if ($request->discount == 0)
                        {
                            if (($driver['min'] < $min['min']) && $driver['category'] == $category->id)
                            {
                                $min = $driver;
                            }
                        }
                        else
                        {
                            if (($driver['discount'] > $min['discount']) && $driver['category'] == $category->id)
                            {
                                $min = $driver;
                            }
                            elseif (($driver['discount'] == $min['discount']) && $driver['category'] == $category->id)
                            {
                                if (($driver['min'] < $min['min']))
                                {
                                    $min = $driver;
                                }
                            }
                        }
                    }
                    $fetchedDriver[$category->id] = $min;
                }
            }
            $i++;
        }
        $fetchedDriverRes = [];
        foreach ($fetchedDriver as $fetch)
        {
            $category = categories::whereId($fetch['category'])->first();
            $fetch['category_name'] = $category->name;
            $fetch['category_image'] = asset('public/avatars').'/'.$category->image;
            $price =($this->calculatePrice($category->id,$totalDistance));
            $fetch['actual_price'] = number_format($price,2);

            if ($request->discount == 1)
            {
                $discount = (float)$fetch['discount'];
                $totalDiscount = (float)((($price)*($discount))/100);
                $fetch['discount_price'] = number_format($price-$totalDiscount,2);
            }
            else
            {
                $fetch['discount_price'] = number_format($price,2);
            }
            array_push($fetchedDriverRes,$fetch);
        }
        return $fetchedDriverRes;
    }


}
