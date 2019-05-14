<?php

namespace App\Http\Controllers\api;

use App\Models\advertisement;
use App\Models\availableCities;
use App\Models\basicFare;
use App\Models\booking;
use App\Models\categories;
use App\Models\cencellation;
use App\Models\driver;
use App\Models\driverCategory;
use App\Models\driverNotification;
use App\Models\driverTips;
use App\Models\favDriver;
use App\Models\filter;
use App\Models\invitedFriends;
use App\Models\minimumFare;
use App\Models\notification;
use App\Models\passenger_rating;
use App\Models\passengers;
use App\Models\passengerStripe;
use App\Models\price;
use App\Models\pricePerMinute;
use App\Models\rank;
use App\Models\rating;
use App\Models\serviceFee;
use App\Models\template;
use App\Models\userCoupons;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use function GuzzleHttp\Psr7\str;
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

    public function getPaymentMethods(Request $request)
    {
        $userDetails = explode('-',$request->user_lat_lng);
        if (!isset($userDetails[0]) || !isset($userDetails[1]) || $userDetails[0] == '' || $userDetails[1] == '' || empty($userDetails[0]) || empty($userDetails[1]))
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "User details are not Valid";
            $response['data'] = [];
            return $response;
        }
        $lat1 = $userDetails[0];
        $lng1 = $userDetails[1];
        $city1 = $this->getAddress($lat1,$lng1);
        $checkCity = $this->checkCity2($city1);
        if($checkCity['code'] == 500)
        {
            return $checkCity;
        }
        $payments = DB::table('payment_methods')->where('city','like',$city1)->get();
        if (empty($payments))
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "No Payment Statuses are Defined";
            $response['data'] = [];
        }
        else
        {
            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Payment Statuses are Fetched Successfully";
            $response['data'] = $payments;
        }
        return $response;
    }

    public function getCategories(Request $request)
    {
        $userDetails = explode('-',$request->user_lat_lng);
        if (!isset($userDetails[0]) || !isset($userDetails[1]) || $userDetails[0] == '' || $userDetails[1] == '' || empty($userDetails[0]) || empty($userDetails[1]))
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "User details are not Valid";
            $response['data'] = [];
            return $response;
        }
        $lat1 = $userDetails[0];
        $lng1 = $userDetails[1];
        $city1 = $this->getAddress($lat1,$lng1);
        $checkCity = $this->checkCity2($city1);
        if($checkCity['code'] == 500)
        {
            return $checkCity;
        }
        $categories = categories::where('city','like',$city1)->get();
        foreach ($categories as $category)
        {
            if ($category->image != '' || !empty($category->image))
            {
                $category->image = asset('public/avatars').'/'.$category->image;
            }
        }

        if (empty($categories))
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "No Categories are Found";
            $response['data'] = [];
        }
        else
        {
            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Categories are Fetched Successfully";
            $response['data'] = $categories;
        }
        return $response;
    }

    public function displayPrice(Request $request)
    {
        if (passengers::whereId($request->userid)->where('phone',$request->phone)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status']     = 'failed';
            $response['message']    = 'This user doesn’t exist';
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
            $response['message']    = 'Enter Valid Source Location';

            return $response;
        }
        $dest = explode( ",", $request->destination );
        if ( isset( $dest[0] ) && isset( $dest[1] ) ) {
            $latDest = $dest[0];
            $lonDest = $dest[1];
        }
        else
        {
            $response['code'] = 500;
            $response['status']     = 'failed';
            $response['message']    = 'Enter Valid Destination Location';

            return $response;
        }
        $distanceTime = $this->calculateDistance($latSrc,$lonSrc,$latDest,$lonDest);
        $userDetais = explode('-',$request->user_lat_lng);
        $latSrc1 = $userDetais[0];
        $lonSrc1 = $userDetais[1];
        $city1 = $this->getAddress($latSrc,$lonSrc);
        $city2 = $this->getAddress($latDest,$lonDest);
        $city3 = $this->getAddress($latSrc1,$lonSrc1);
        $checkCity = $this->checkCity($city1,$city2,$city3);
        if ($checkCity['code'] == 500)
        {
            return $checkCity;
        }
        $input['distance'] = $distanceTime['distance'];
        $input['estimated_time'] = $distanceTime['time'];
        if (categories::where('city','like',$city1)->orWhere('city','like',$city2)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status']     = 'failed';
            $response['message']    = 'No categories are Found';
            $response['data']    = [];
        }
        if ((!isset($userDetais[0]) || $userDetais[0] == '' || empty($userDetais[0])) || (!isset($userDetais[1]) || $userDetais[1] == '' ||  empty($userDetais[1])))
        {
            $response['status'] = "failed";
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
                $response['status'] = "failed";
                $response['message'] = "No Favorite Drivers are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;
            }
            elseif($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 1)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "No Favorite Drivers Offering Discount are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;

            }
            elseif($request->favoriteDriver == 0 && count($drivers) < 1 && $request->discount == 1)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "No nearby Drivers Offering Discount are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;

            }
            elseif (count($drivers) < 1)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
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
                $response['status'] = "failed";
                $response['message'] = "No Favorite Drivers are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;

            }
            elseif($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 1)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "No Favorite Drivers with Offering Discount are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;

            }
            elseif($request->favoriteDriver == 0 && count($drivers) < 1 && $request->discount == 1)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "No nearby Drivers Offering Discount are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;

            }
            elseif (count($drivers) < 1)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "No Drivers are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;
            }
        }
        $responseDriver=app('App\Http\Controllers\api\bookingDriverApiController')->fetchNearbyDrivers($drivers,$latSrc,$lonSrc);
        $drivers = $responseDriver['data'];
        if (empty($drivers))
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            if ($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 0)
            {
                $response['message'] = "No Favorite Drivers are Found";
            }
            elseif($request->favoriteDriver == 1 && count($drivers) < 1 && $request->discount == 1)
            {
                $response['message'] = "No Favorite Drivers offering discount are Found";
            }
            elseif($request->favoriteDriver == 0 && count($drivers) < 1 && $request->discount == 1)
            {
                $response['message'] = "No Nearby Drivers offering discount are Found";
            }
            else
            {
                $response['message'] = "No Drivers are Found";
            }
            $response['data'] = [];
            return $response;
        }
        $fetchedDrivers = $this->getFilteredDriver($drivers,$request,$distanceTime);

        if ($fetchedDrivers == null)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "No drivers are found";
            $response['data'] = [];
            return $response;
        }
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Category with Price and time to reach is fetched successfully";
        if ($distanceTime['distance'] < 1)
        {
            $distanceTime['distance'] = $distanceTime['distance']*100;
            $distanceTime['distance'] = number_format($distanceTime['distance'],'2').' Metres';
        }
        else
        {
            $distanceTime['distance'] = number_format($distanceTime['distance'],'2').' Km';
        }
        $response['estimated_ride_distance'] = $distanceTime['distance'];
        $response['estimated_ride_time'] = $distanceTime['time'];
        $response['data'] = $fetchedDrivers;
        return $response;


    }

    public function booking(Request $request)
    {
        if (!isset($request->payment_method_id) || $request->payment_method_id == null || empty($request->payment_method_id) || $request->payment_method_id == '')
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Select your preferable Payment Method";
            $response['data'] = [];
            return $response;
        }
        if (passengers::whereId($request->userid)->exists())
        {
            $user = passengers::whereId($request->userid)->first();
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
            $city1 = $this->getAddress($latSrc,$lonSrc);
            $city2 = $this->getAddress($latDest,$lonDest);
            $userDetais = explode('-',$request->user_lat_lng);
            $lat1 = $userDetais[0];
            $long1 = $userDetais[1];
            $city3 = $this->getAddress($lat1,$long1);
            $checkCity = $this->checkCity($city1,$city2,$city3);
            if ($checkCity['code'] == 500)
            {
                return $checkCity;
            }
            $input['distance'] = $distanceTime['distance'];
            $input['estimated_time'] = $distanceTime['time'];

            $price = $this->calculatePrice($request->categoryId,$input['distance'],$distanceTime['min'],$distanceTime['city']);
            $estimate = ($price*10)/100;
            $estimate +=$price;
            $input['original_price'] = $price.' - '.$estimate;
            $input['price'] = $price.' - '.$estimate;
            if($request->discount == 1)
            {
                $input['discount'] = 1;
            }
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
                    $response['message'] = "Un-Supported Image Format";
                    $response['Data'] = [];
                    return $response;
                }
            }


            if ((!isset($userDetais[0]) || empty($userDetais[0])) || (!isset($userDetais[1]) ||  empty($userDetais[1])))
            {
                $response['status'] = "failed";
                $response['code'] = 500;
                $response['message'] = "Invalid user data Received! Format- user_lat_lng = 'lat-lng'";
                $response['data'] = [];
                return $response;
            }

            if (isset($request->payment_method_id)  && $request->payment_method_id != '' || !empty($request->payment_method_id))
            {
                if (DB::table('payment_methods')->whereId($request->payment_method_id)->exists() == 0)
                {
                    $response['status'] = "failed";
                    $response['code'] = 500;
                    $response['message'] = "This payment method is not Accepted";
                    $response['data'] = [];
                    return $response;
                }
            }
            else
            {
                $request->payment_method_id = null;
            }
            $drivers=app('App\Http\Controllers\api\bookingDriverApiController')->driverByCategory($request->categoryId,$request->favoriteDriver,$request->discount,$request->userid,$request->payment_method_id);
            if (count($drivers) < 1)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "No Drivers are Found!";
                $response['favorite_driver_filter'] = 0;
                $response['discount_available_filter'] = 0;
                $response['data'] = [];
                return $response;
            }

            $response=app('App\Http\Controllers\api\bookingDriverApiController')->fetchNearbyDrivers($drivers,$latSrc,$lonSrc);
            if ($response['code'] != 200 || count($response['data']) < 1)
            {
                $response['status'] = "failed";
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
                    $score[$driverid] = $this->assignDriver($driverid,$lat1,$long1);

                }
            }
            $input['otp'] = substr(str_shuffle("0123456789"), 0, 4);
            if (isset($score) && count($score) > 0)
            {
                $booking = booking::create($input);
                if ($booking->image != '' || !empty($booking->image))
                {
                    $booking->image = asset('public/avatars').'/'.$booking->image;
                }
//********************************************************************************************
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
                DB::table('bookingDriver_push')->insert(['bookingid'=>$booking->id,'array'=>$newScore,'full_array'=>$newScore]);

            }
            else
            {
                $response['status'] = "failed";
                $response['code'] = 500;
                $response['message'] = "No drivers are Active at the moment";
                $response['data'] = [];
                return $response;
            }

            if (template::where('type','system')->where('title','Booking Confirm')->exists())
            {
                $template = template::where('type','system')->where('title','Booking Confirm')->first();
                $message = str_replace('xxx',$booking->id,$template->message);
                $notification['message'] = $message;
                $notification['image'] = $template->image;
                $notification['title'] = $template->title;
            }
            else
            {
                $notification['message'] = "Your Ride #".$booking->id." is Successfull";
            }
            $notification['userid'] = $request->userid;
            $notification['type'] = "System";
            notification::create($notification);

            $response['status'] = "success";
            $response['code'] = 200;
            $response['favorite_driver'] = $request->favoriteDriver;
            $response['message'] = "Booking Saved Successfully!";
            $response['data'] = $booking;

            return $response;

        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Looks like something went wrong with your number";
            $response['data'] = [];
            return $response;
        }
    }
    public function rideAcceptNotification(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
            return $response;
        }
        if (booking::whereId($request->bookingid)->where('userid',$request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "The booking is Not associated to this User";
            $response['data'] = [];
            return $response;
        }
        $booking = booking::whereId($request->bookingid)->where('userid',$request->userid)->first();
        $user = passengers::whereId($booking->userid)->first();
        $nextDrivers = DB::table('bookingDriver_push')->where('bookingid',$booking->id)->first();
        $nextDrivers = explode(',',$nextDrivers->array);
        if(!isset($nextDrivers[0]))
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "No drivers Found";
            $response['data'] = [];
            return $response;
        }
        foreach ($nextDrivers as $nextDriver)
        {
            $driverNext = explode('-',$nextDriver);
            $drievr[$driverNext[0]] = $driverNext[1];
        }
        $driverid = array_search(max($drievr),$drievr);

        $riderDetails = driver::whereId($driverid)->first();
//        $riderDetails = driver::whereId(27)->first();
        unset($riderDetails->password);
        unset($user->password);

//        *********************************Code for Push Notification *************************************************

//        $riderDetails = driver::whereId(17)->first();
        $title = "Ride Request";
        $pushFor = "Accept Ride";
        $token = (string)$riderDetails->device_token;
        $body['username'] = $user->fname.' '.$user->lname;
        $body['booking_details'] = $booking;
        $body['driverid'] = $riderDetails->id;
        $body['user_rating'] = $this->getUserRating($user->id);
        $body['message'] = "Ride Request";
        $UserpushNotification = parent::pushNotification($title,$body,$token,$riderDetails,$pushFor);

//        **************************************************************************************************************
        unset($drievr[$driverid]);
        $newScore = "";
        foreach ($drievr as $key => $value)
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
        DB::table('bookingDriver_push')->where('bookingid',$request->bookingid)->update(['bookingid'=>$request->bookingid,'array'=>$newScore]);



        $response['code'] = 200;
        $response['status'] = "success";
        $response['driverid'] = $riderDetails->id;
        $response['message'] = "Notification sent Successfully";
        $response['data'] = [];
        return $response;

    }


    public function editBooking(Request $request)
    {
        if(passengers::whereId($request->userid)->exists() == 0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Booking could not be Found";
            $response['data'] = [];
            return $response;
        }
        $user = passengers::whereId($request->userid)->first();
        if (booking::whereId($request->bookingId)->where('userid',$request->userid)->exists())
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
                $update['price'] = $this->calculatePrice($request->categoryId,$update['distance'],$distanceTime['min'],$distanceTime['city']);
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
            $riderDetails = driver::whereId($booking->driverid)->first();
            if ($booking->image != '' || !empty($booking->image))
            {
                $booking->image = asset('public/avatars').'/'.$booking->image;
            }
            $response['status'] = "success";
            $response['code'] = 500;
            $response['message'] = "Booking Edited Successfully";
            $response['data'] = $booking;
            unset($riderDetails->password);
            unset($user->password);
//*********************************************Code to send the Push Notification'***************************************

            $title = "Ride Request";
            $pushFor = "Accept Ride";
            $token = $riderDetails->device_token;
            $body['username'] = $user->fname.' '.$user->lname;
            $body['message'] = "Ride Request";
            $body['user_rating'] = $this->getUserRating($user->id);
            $body['bookingDetails'] = $booking;
            $pushNotification = parent::pushNotification($title,$body,$token,$riderDetails,$pushFor);


//                            When Booking is changed, Driver App will get notified
//            *****************************************************************************************

        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Booking could not be Found";
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
                    $response['status'] = "success";
                    $response['code'] = 200;
                    $response['message'] = "Cancellation Fees Obtained Successfully";
                    $response['data'] = $cancellationFee;
                }
                else
                {
                    $cancellationFee= 0;
                    $response['status'] = "success";
                    $response['code'] = 200;
                    $response['message'] = "Cancellation Fees Obtained Successfully";
                    $response['data'] = $cancellationFee;
                }
            }
            else
            {
                $response['status'] = "failed";
                $response['code'] = 500;
                $response['message'] = "Booking could not be Found";
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

    public function cancelBooking(Request $request)
    {
        $now = time();
        if (booking::whereId($request->bookingid)->where('userid',$request->userid)->exists() == 0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Booking could not be found";
            $request['data'] = [];
            return $response;
        }
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This user doesn’t exist";
            $request['data'] = [];
            return $response;
        }
        elseif(booking::whereId($request->bookingid)->where('userid',$request->userid)->where('cancelled_at',null)->orWhere('cancelled_at','')->exists())
        {
            $user = passengers::whereId($request->userid)->first();
            $booking = booking::whereId($request->bookingid)->where('userid',$request->userid)->where('cancelled_at',null)->orWhere('cancelled_at','')->first();
            $riderDetails = driver::whereId($booking->driverid)->first();
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

        if ($booking->payment_method == 1)
        {
            $updateBooking['status'] = "cancelled";
            $updateBooking['cancelled_at'] = new \DateTime();
            $updateBooking['cancelled_by'] = "user";
            booking::whereId($request->bookingid)->update($updateBooking);

            if (template::where('type','system')->where('title','Booking Cancel')->exists())
            {
                $template = template::where('type','system')->where('title','Booking Cancel')->first();
                $message = str_replace('xxx',$booking->id,$template->message);
                $driver_notification['message'] = $message;
                $notification['message'] = $message;
                $driver_notification['image'] = $template->image;
                $notification['image'] = $template->image;
            }
            else
            {
                $notification['message'] = "Your Booking #".$booking->id." is Cancelled";
                $driver_notification['message'] = "Your Booking #".$booking->id." is Cancelled";
            }
            $notification['userid'] = $request->userid;
            $driver_notification['driverid'] = $booking->driverid;
            $notification['type'] = "System";
            notification::create($notification);
            driverNotification::create($driver_notification);
            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Booking Cancelled Successfully!";
            $response['data'] = booking::whereId($request->bookingid)->first();
            return $response;

        }

            if ($totalTime > $totalMin && $totalPrice > 0)
            {
                $response['code'] = 500;
                $response['success'] = "failed";
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
                $driver_notification['message'] = $message;
                $notification['message'] = $message;
                $driver_notification['image'] = $template->image;
                $notification['image'] = $template->image;
            }
            else
            {
                $notification['message'] = "Your Booking #".$booking->id." is Cancelled";
                $driver_notification['message'] = "Your Booking #".$booking->id." is Cancelled";
            }
            $notification['userid'] = $request->userid;
            $driver_notification['driverid'] = $booking->driverid;
            $notification['type'] = "System";
            notification::create($notification);
            driverNotification::create($driver_notification);

            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Booking Cancelled Successfully!";
            $response['data'] = booking::whereId($request->bookingid)->first();

//            *****************************************Code to send the Push Notification****************************
            $title = "Ride Cancel";
            $pushFor = "Cancel Ride";
            $token = $riderDetails->device_token;
            $body['username'] = $user->fname.' '.$user->lname;
            $body['message'] = "Ride Cancel";
            $body['user_rating'] = $this->getUserRating($user->id);
            $body['bookingDetails'] = $booking;
            $pushNotification = parent::pushNotification($title,$body,$token,$riderDetails,$pushFor);

//            ************************************************************


            return $response;
        }
        else
        {
            $response['status'] = "failed";
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
            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Rating saved Successfully";
            $response['data'] = $rate;
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Booking could not be found";
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
            $response['status'] = "success";
            $response['code'] = 200;
            $response['message'] = "Bookings fetched Successfully";
            $response['data'] = $bookings;
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
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
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
            return $response;
        }
        if (booking::where('userid',$userid)->exists() ==0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "User have not booked any ride till now";
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
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "No Bookings are found on that day";
            $response['data'] = [];
            return $response;
        }
        $response['status'] = "success";
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
                $response['status'] = "success";
                $response['code'] = 200;
                $response['message'] = "Rating Fetched Succeessfully";
                $response['data'] = $rate;
            }
            else
            {
                $response['status'] = "failed";
                $response['code'] = 500;
                $response['message'] = "Rating for Booking is Empty";
                $response['data'] = [];
            }
        }
        else
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Booking could not be found";
            $response['data'] = [];
        }
        return $response;
    }

    public function fetchNearbyAds(Request $request)
    {
        if (!isset($request->lat) || ($request->lat == '' || empty($request->lat)))
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Destination latitude can not be empty";
            $response['data'] = [];
            return $response;
        }
        if (!isset($request->lng) || ($request->lng == '' || empty($request->lng)))
        {
            $response['code'] = 500;
            $response['status'] = "failed";
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
            $response['code'] = 500;
            $response['status'] = "failed";
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
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "No advertisements Found";
            $response['data'] = [];
        }
        else
        {
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "Advertisements fetched successfully";
            $response['data'] = $totalAds;
        }
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

    function calculatePrice($category,$distance,$totalMin,$city)
    {
        $cityDetails=availableCities::where('city','like',$city)->first();
        $categoryPrice = price::where('category',$category)->where('city',$cityDetails->id)->first();
        $minutePrice = pricePerMinute::where('category',$category)->where('city',$cityDetails->id)->first();
        $basicFee = basicFare::where('category',$category)->where('city',$cityDetails->id)->first();
        $serviceFee = serviceFee::where('category',$category)->where('city',$cityDetails->id)->first();
        $minimumFare = minimumFare::where('category',$category)->where('city',$cityDetails->id)->first();
        if (!empty($basicFee))
        {
            $basicFee = $basicFee->amount;
        }
        else
        {
            $basicFee = 0;
        }
        if (!empty($serviceFee))
        {
            $serviceFee = $serviceFee->amount;
        }
        else
        {
            $serviceFee = 0;
        }
        if (!empty($minimumFare))
        {
            $minimumFare = $minimumFare->amount;
        }
        else
        {
            $minimumFare = 0;
        }
        if (!empty($categoryPrice))
        {
            $categoryPerKM = $categoryPrice->amount;
        }
        else
        {
            $categoryPerKM = 0;
        }
        if(!empty($minutePrice))
        {
            $pricePerMin = $minutePrice->amount;

        }
        else
        {
            $pricePerMin = 0;
        }
        $price = $basicFee+$serviceFee+$categoryPerKM*$distance+$pricePerMin*$totalMin;
        if ($price <= $minimumFare)
        {
            $price = $minimumFare;
        }
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
            elseif ($address['types'][0] == 'administrative_area_level_1')
            {
                $city = $address['long_name'];
            }
            elseif ($address['types'][0] == 'administrative_area_level_2')
            {
                $city = $address['long_name'];
            }
        }
        return $city;

//        return $response_a['results'][0]['address_components'];
    }

    function getDriver($discount,$favorite,$userid,$payment=null)
    {
        if ($discount == 0)
        {
            $drivers = driver::where('status',1)->where('isAvailable',1)->where('active_ride',0)->get();
        }
        else
        {
            $drivers = driver::where('status',1)->where('isAvailable',1)->where('active_ride',0)->where('discount','!=',0)->orderby('discount','desc')->get();
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
                            $driverDetail = driver::whereId($pay->driverid)->where('status',1)->where('active_ride',0)->first();
                        }
                        else
                        {
                            $driverDetail = driver::whereId($pay->driverid)->where('status',1)->where('active_ride',0)->where('discount','!=',0)->first();
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
        $user = passengers::whereId($request->userid)->first();
        if($request->discount == 1)
        {
            if(rank::whereId($user->rankid)->first(['discount']))
            {
                $rank = rank::whereId($user->rankid)->first(['discount']);
                $userMaxDiscount = (float)$rank->discount;
            }
            else
            {
                $userMaxDiscount = 0;
            }
        }
        $totalDistance = $distanceTime['distance'];
        $totalMin = $distanceTime['min'];
        $city = $distanceTime['city'];
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
                $driverCategories = driverCategory::where('driverid',$driver['driverid'])->where('city','like',$city)->first(['categoryid']);
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
        $categories = categories::where('city','like',$city)->get();
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
                            if (($driver['discount'] > $min['discount']) && ($driver['discount'] <= $userMaxDiscount) && $driver['category'] == $category->id)
                            {
                                $min = $driver;
                            }
                            elseif (($driver['discount'] == $min['discount']) && ($driver['discount'] <= $userMaxDiscount) && $driver['category'] == $category->id)
                            {
                                if (($driver['min'] < $min['min']))
                                {
                                    $min = $driver;
                                }
                            }
                        }
                    }
                    if($request->discount == 1)
                    {
                        if ($min['discount'] <= $userMaxDiscount)
                        {
                            $fetchedDriver[$category->id] = $min;
                        }
                    }
                    else
                    {
                        $fetchedDriver[$category->id] = $min;
                    }

                }
            }
            $i++;
        }
        if (!isset($fetchedDriver) ||count($fetchedDriver) < 1 || empty($fetchedDriver))
        {
            return null;
        }
        $fetchedDriverRes = [];
        foreach ($fetchedDriver as $fetch)
        {
            $category = categories::whereId($fetch['category'])->first();
            $fetch['category_name'] = $category->name;
            $fetch['category_image'] = asset('public/avatars').'/'.$category->image;
            $price =($this->calculatePrice($category->id,$totalDistance,$totalMin,$city));
            $estimate = ($price*10)/100;
            $estimate = $estimate+$price;
            $fetch['estimated_actual_price'] = number_format($price,2).' - '.number_format($estimate,2);

            if ($request->discount == 1)
            {
                $discount = (float)$fetch['discount'];
                $totalDiscount = (float)((($price)*($discount))/100);
                $discountPrice = $price-$totalDiscount;
                $discountEstimate = ($discountPrice*10)/100;
                $discountEstimate = $discountEstimate+$discountPrice;
                $fetch['estimated_discount_price'] = number_format($discountPrice,2).' - '.number_format($discountEstimate,2);
            }
            else
            {
                $fetch['discount_price'] = number_format($price,2).' - '.number_format($estimate,2);
            }
            if($fetch['estimated_distance'] < 1)
            {
                $fetch['estimated_distance'] = ($fetch['estimated_distance']*1000);
                $fetch['estimated_distance'] = $fetch['estimated_distance'].' metres';
            }
            else
            {
                $fetch['estimated_distance'] = number_format($fetch['estimated_distance'],'2').' Km';
            }
            if ($request->discount == 1)
            {
                $fetch['discount'] = $fetch['discount'].'%';
            }
            array_push($fetchedDriverRes,$fetch);
        }
        return $fetchedDriverRes;
    }

    function checkCity($city1,$city2,$city3)
    {
            if (availableCities::where('city','like',$city1)->exists()== 0)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "ChauffeurX is Still not Available at ".$city1;
                $response['data'] = [];
                return $response;
            }
            elseif(availableCities::where('city','like',$city2)->exists()== 0)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "ChauffeurX is Still not Available at ".$city2;
                $response['data'] = [];
                return $response;
            }
            elseif(availableCities::where('city','like',$city3)->exists()== 0)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "ChauffeurX is Still not Available at ".$city3;
                $response['data'] = [];
                return $response;
            }
            else
            {
                $response['code'] = 200;
                $response['status'] = "success";
                $response['message'] = "ChauffeurX is available";
                $response['data'] = [];
                return $response;
            }
    }
    function checkCity2($city)
    {
        if (availableCities::where('city','like',$city)->exists()== 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "ChauffeurX is Still not Available at ".$city;
            $response['data'] = [];
            return $response;
        }
        else
        {
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "ChauffeurX is available";
            $response['data'] = [];
            return $response;
        }
    }

    public function getUserRating($userid)
    {
        if (passengers::whereId($userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
            return $response;
        }
        $count = passenger_rating::where('userid',$userid)->count();
        if ($count == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "User has no Rating";
            $response['data'] = [];
            return $response;
        }
        $ratings = passenger_rating::where('userid',$userid)->get();
        $rate = 0;
        foreach ($ratings as $rating)
        {
            $rate +=(int)$rating->rating;
        }
        $rate = $rate/$count;
        return number_format($rate,2);
    }

    function assignDriver($driverid,$lat1,$long1)
    {
        $waitTime = $this->getDriverWaitTime($driverid,$lat1,$long1);
        if ($waitTime == 0)
        {
            $score[$driverid] = 0;
            $score = (0)+($this->getDriverRating($driverid)/10)+($this->driverSevenBookings($driverid)/100)-($this->getPenalty($driverid));
            return $score;
        }
        $score[$driverid] = 1/$this->getDriverWaitTime($driverid,$lat1,$long1);
//        return $score;
        $score = (1/$this->getDriverWaitTime($driverid,$lat1,$long1))+($this->getDriverRating($driverid)/10)+($this->driverSevenBookings($driverid)/100)-($this->getPenalty($driverid));
        return $score;
    }

    function getDriverWaitTime($driverid,$lat1,$long1)
    {
        $driver = driver::whereId($driverid)->first();
        $coordinates=$this->database->getReference('online_drivers')->getChild($driver->id)->getValue();
        $lat2 = $coordinates['lat'];
        $long2 = $coordinates['lng'];
        $distance=app('App\Http\Controllers\api\bookingApiController')->calculateDistance($lat1,$long1,$lat2,$long2);
//        $distance = $this->calculateDistance($lat1,$long1,$lat2,$long2);
        $minutes = $distance['min'];
        if($minutes <= 1)
        {
            $minutes = 1;
        }
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

}
