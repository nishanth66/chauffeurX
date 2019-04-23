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
use App\Models\favoriteAddress;
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

class bookingDriverApiController extends Controller
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
            $coordinates['discount'] = $driver->discount;
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
                $Totaldistance=app('App\Http\Controllers\api\bookingApiController')->calculateDistance($lat1,$long1,$lat2,$long2);
//                $Totaldistance = $this->calculateDistance($lat1,$long1,$lat2,$long2);
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
                    $array['discount'] = $driver['discount'];
                    $latLng[$id] = $array;
                }
            }
        }
        if (isset($distance) && ($distance != '' || !empty($distance)))
        {
            asort($distance);
            if (count($distance) > 10)
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

    function driverByCategory($categoryid,$fav,$discount,$userid,$payment=null)
    {
        if ($discount == 0)
        {
            $drivers = DB::select("select d.* from drivers d,driver_categories c where d.id=c.driverid and c.categoryid=$categoryid and d.deleted_at is null and c.deleted_at is null and d.isAvailable = 1 and d.status = '1'");
        }
        else
        {
            $drivers = DB::select("select d.* from drivers d,driver_categories c where d.id=c.driverid and c.categoryid=$categoryid and d.deleted_at is null and c.deleted_at is null and d.isAvailable = 1 and d.status = '1' and discount != 0");
        }
        if($payment != null && $fav == 0)
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
        elseif (($payment == null || $payment == '') && $fav == 1)
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
        elseif (($payment != null || $payment != '') && $fav == 1)
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
        $distance=app('App\Http\Controllers\api\bookingApiController')->calculateDistance($lat1,$long1,$lat2,$long2);
//        $distance = $this->calculateDistance($lat1,$long1,$lat2,$long2);
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

}
