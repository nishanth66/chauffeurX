<?php

namespace App\Http\Controllers\api;

use App\Models\booking;
use App\Models\categories;
use App\Models\driver;
use App\Models\driverCategory;
use App\Models\driverNotification;
use App\Models\driverPaymentHistory;
use App\Models\passenger_rating;
use App\Models\passengers;
use App\Models\preferences;
use App\Models\rating;
use App\Models\template;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\api\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Twilio\Exceptions\RestException;

class driverApiController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (driver::where('email',$email)->exists()) {
            $driverDetails = explode(',',$request->driver_lat_lng);
            $driver = driver::where('email', $email)->first();
//            if(isset($driverDetails[0]) && isset($driverDetails[1]) && !empty($driverDetails[0]) && !empty($driverDetails[1]))
//            {
//                $lat = $driverDetails[0];
//                $lng = $driverDetails[1];
//                $city = app('App\Http\Controllers\api\bookingApiController')->getAddress($lat,$lng);
//                driver::whereId($driver->id)->update(['city'=>$city]);
//                $driver = driver::whereId($driver->id)->first();
//            }
            if ($driver->payment == 0)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "You cant ride without paying subscription.";
                $response['data'] = [];
                return $response;
            }
            elseif ($driver->status != 1)
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "You cant ride without getting verified.";
                $response['data'] = [];
                return $response;
            }
            if (Hash::check($password, $driver->password) && $email == $driver->email) {
                $response['code'] = 200;
                $response['status'] = "success";
                $response['message'] = "Logged in Successfully";
                $response['data'] = $driver;
                driver::whereId($driver->id)->update(['device_token' => $request->device_token,'device_type' => $request->device_type]);
            }
            else
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "Email and Password do no match";
                $response['data'] = [];
            }
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This driver doesn’t exist";
            $response['data'] = [];
        }
        return $response;
    }
    
    public function rateCustomer(Request $request)
    {
        if(booking::whereId($request->bookingid)->where('driverid',$request->driverid)->exists())
        {
            $booking = booking::whereId($request->bookingid)->first();
            $rate = passenger_rating::create([
                'userid' => $booking->userid,
                'bookingid' => $booking->id,
                'driverid' => $request->driverid,
                'rating' => $request->rating,
                'comments' => $request->comments,
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
            $response['message'] = "Booking is not assigned to this driver";
            $response['data'] = [];
        }
        return $response;
    }

    public function tripEnd(Request $request)
    {
        if (booking::whereId($request->bookingid)->exists())
        {
            if (booking::whereId($request->bookingid)->where('driverid',$request->driverid)->exists())
            {
                $update['status'] = "completed";
                $update['trip_end_time'] = new \DateTime();
                booking::whereId($request->bookingid)->update($update);
                $booking = booking::whereId($request->bookingid)->first();

                $start = strtotime($booking->trip_start_time);
                $end = strtotime($booking->trip_end_time);
                $mins = ($end-$start)/100;
                $category = $booking->categoryId;
                $source = explode(',',$booking->source);
                $dest = explode(',',$booking->destination);
                $distance=app('App\Http\Controllers\api\bookingApiController')->calculateDistance($source[0],$source[1],$dest[0],$dest[1]);
                $price = app('App\Http\Controllers\api\bookingApiController')->calculatePrice($category,$distance['distance'],$mins,$distance['city']);
                $priceUpdate['original_price'] = round($price);
                $priceUpdate['price'] = round($price);
                $response['amount_to_pay'] = round($price);
                if ($booking->discount == 1)
                {
                    $driver = driver::whereId($request->driverid)->first();
                    $disc = $driver->discount;
                    $totalDisc = ($disc*$price)/100;
                    $descPrice = $price-$totalDisc;
                    $priceUpdate['price'] = round($descPrice);
                    $response['amount_to_pay'] = round($descPrice);
                }
                booking::whereId($request->bookingid)->update($priceUpdate);
                driver::whereId($request->driverid)->update(['active_ride'=>0,'isAvailable'=>1]);
                $booking = booking::whereId($request->bookingid)->first();
                passengers::whereId($booking->userid)->update(['active_ride'=>0]);
                $user = passengers::whereId($booking->userid)->first();
                $response['code'] = 200;
                $response['status'] = "success";
                $response['message'] = "Booking Updated Successfully";
                $response['data'] = $booking;

//   *******************************************Code for Push Notification ***********************************************
                $title = "Ride End";
                $pushFor = "Ride End";
                $token = $user->device_token;
                $body['username'] = $user->fname.' '.$user->lname;
                $msg = "Ride End";
                $body['message'] = $msg;
                $body['booking_id'] = $booking->id;
                $body['userid'] = $booking->userid;
                $body['phone'] = $booking->phone;
                $body['source'] = $booking->source;
                $body['destination'] = $booking->destination;
                $body['original_price'] = $booking->original_price;
                $body['price'] = $booking->price;
                $body['distance'] = $booking->distance;
                $body['estimated_time'] = $booking->estimated_time;
                $pushNotification = parent::pushNotification($title,$body,$token,$user,$pushFor,$msg,1);
//                **************************************************************************************
            }
            else
            {
                $response['code'] = 500;
                $response['status'] = "failed";
                $response['message'] = "Booking is not associated to this Driver";
                $response['data'] = [];
            }

        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Booking could not be found";
            $response['data'] = [];
        }
        return $response;
    }

    public function rideHistory(Request $request)
    {
        if (driver::whereId($request->driverid)->exists() == 0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Driver could not be found";
            $response['data'] = [];
        }
        if(booking::where('driverid',$request->driverid)->exists() == 0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Driver has no Ride History";
            $response['data'] = [];
        }
        $myBookings = array();
        if (isset($request->date) && ($request->date != '' || $request->date != null))
        {
            $toDate = strtotime(str_replace('/','-',$request->date));
            $newDate = date('Y-m-d',$toDate);
            $newDate = new \DateTime($newDate);
            $bookings = booking::where('driverid',$request->driverid)->whereDate('trip_start_time',$newDate)->orderby('id','desc')->get();
        }
        else
        {
            $bookings = booking::where('driverid',$request->driverid)->orderby('id','desc')->get();
        }
        foreach ($bookings as $booking) {
            if ($booking->source_address == null || empty($booking->source_address))
            {
                $booking->source_address = "";
                $booking->destination_address = "";
            }
            array_push($myBookings,$booking);
        }
        if (empty($myBookings) || count($myBookings) < 1)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "No Bookings found on that day";
            $response['data'] = [];
            return $response;
        }
        $response['status'] = "success";
        $response['code'] = 200;
        $response['message'] = "Driver Bookings fetched Successfully";
        $response['data'] = $myBookings;
        return $response;
    }

    public function arrived(Request $request)
    {
        if (booking::whereId($request->bookingid)->exists() == 0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['Message'] = "Booking could not be found";
            $response['data'] = [];
            return $response;
        }
        elseif (booking::whereId($request->bookingid)->where('driverid',$request->driverid)->exists() == 0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['Message'] = "Booking is not associated to this driver";
            $response['data'] = [];
            return $response;
        }
        booking::whereId($request->bookingid)->where('driverid',$request->driverid)->update(['driver_arrived_at'=>new \DateTime(),'status'=>'driver arrived']);
        $booking = booking::whereId($request->bookingid)->first();
        $user = passengers::whereId($booking->userid)->first();
        $riderDetails = driver::whereId($booking->driverid)->first();
//        $user = passengers::whereId(1)->first();
        $response['status'] = "success";
        $response['code'] = 200;
        $response['Message'] = "Booking updated successfully";
        $response['data'] = $booking;

//   *******************************************************Code for Push Notification************************************

        $title = "Booking Verification Code";
        $pushFor = "Booking Verification Code";
        $token = (string)$user->device_token;
        $body['username'] = $user->fname.' '.$user->lname;
        $body['booking_id'] = $booking->id;
        $body['driver_id'] = $booking->driverid;
        $body['driver_name'] = $riderDetails->first_name.' '.$riderDetails->middle_name.' '.$riderDetails->last_name;
        $body['driver_email'] = $riderDetails->email;
        $body['driver_phone'] = $riderDetails->code.$riderDetails->phone;
        $body['driver_rating'] = $this->driverRating($riderDetails->id);
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
//        *************************************************************************************************
        return $response;
    }

    public function inviteFriends(Request $request)
    {
        $driverid = $request->driverid;
        if(driver::whereId($driverid)->exists() == 0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Driver could not be found";
            $response['data'] = [];
            return $response;
        }
        $driver = driver::whereId($driverid)->first();
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
                $input['driver_id'] = $driverid;
                $input['driver_code'] = $driver->referal_code;
                DB::table('driverInvites')->insert($input);
            }
            catch (RestException $ex)
            {
                $response['status'] = "failed";
                $response['code'] = 500;
                $response['message'] = "Failed to send the Invitation";
                $response['data'] = $ex->getMessage();
                $response['mobile_number'] = $number;
                array_push($error,$response);
                DB::table('driverInvites')->where('phone',$number)->where('invite_id',$invitationid)->delete();
//                $error['response'] .= $response;
            }

        }
        if ($error == '' || empty($error))
        {
            $invited_users = DB::table('driverInvites')->where('invite_id',$invitationid)->get();
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

    public function changeAvailableStatus(Request $request)
    {
        if (driver::whereId($request->driverid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be found";
            $response['data'] = [];
            return $response;
        }
        driver::whereId($request->driverid)->update(['isAvailable'=>$request->isAvailable]);
        $driver = driver::whereId($request->driverid)->first();
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Driver available status changed updated successfully";
        $response['data'] = $driver;
        return $response;
    }

    public function acceptBooking(Request $request)
    {
        if (driver::whereId($request->driverid)->where('status',1)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be found";
            $response['data'] = [];
            return $response;
        }
        $driver = driver::whereId($request->driverid)->first();
        if (isset($driver->image) && $driver->image != '' || !empty($driver->image))
        {
            $driver->image = asset('public/avatars').'/'.$driver->image;
        }
        if (booking::whereId($request->bookingid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Booking could not be found";
            $response['data'] = [];
            return $response;
        }
        if (booking::whereId($request->bookingid)->where('driverid',null)->orWhere('driverid','')->exists() ==0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Booking has already assigned to other Driver";
            $response['data'] = [];
            return $response;
        }
        $booking = booking::whereId($request->bookingid)->first();
        if ($booking->discount == 1)
        {
            $prices = explode(' - ',$booking->price);
            $price = $prices[0];
            if ($driver->discount != 0)
            {
                $discount = $driver->discount;
            }
            else
            {
                $discount = 0;
            }
            $totalDiscount = ($price*$discount)/100;
            $newPrice = $price-$totalDiscount;
            $estimate = ($newPrice*10)/100;
            $estimate +=$newPrice;
            $input['price'] = $newPrice.' - '.$estimate;
        }
        $input['driverid'] = $request->driverid;
        $input['status'] = 'accepted';
        booking::whereId($request->bookingid)->update($input);
        driver::whereId($request->driverid)->update(['active_ride'=>1]);
        $booking = booking::whereId($request->bookingid)->first();
        $user = passengers::whereId($booking->userid)->first();
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
        $notification['driverid'] = $driver->id;
        $notification['type'] = "System";
        driverNotification::create($notification);

//   *******************************************************Code for Push Notification ***********************************
//
        $title = "Driver Assigned";
        $pushFor = "Driver Assigned";
        $token = $user->device_token;
        $body['driver_name'] = $driver->first_name.' '.$driver->middle_name.' '.$driver->last_name;
        $body['booking_id'] = $booking->id;
        $body['userid'] = $booking->userid;
        $body['phone'] = $booking->phone;
        $body['source'] = $booking->source;
        $body['destination'] = $booking->destination;
        $body['original_price'] = $booking->original_price;
        $body['price'] = $booking->price;
        $body['distance'] = $booking->distance;
        $body['estimated_time'] = $booking->estimated_time;
        $msg = "Driver Assigned";
        $body['message'] = $msg;
        $body['driver_id'] = $driver->id;
        $body['driver_image'] = $driver->image;
        $body['driver_email'] = $driver->email;
        $body['driver_phone'] = $driver->code.$driver->phone;
        $body['driver_rating'] = $this->driverRating($driver->id);
        $body['driver_device_token'] = (string)$driver->device_token;
        $body['title'] = $title;
        $pushNotification = parent::pushNotification($title,$body,$token,$user,$pushFor,$msg,1);

//        *************************************************************************************************
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Booking accepted successfully";
        $response['data'] = $booking;
        return $response;
    }

    public function rejectBooking(Request $request)
    {
        if (driver::whereId($request->driverid)->where('status',1)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be found";
            $response['data'] = [];
            return $response;
        }
        if(booking::whereId($request->bookingid)->where('driverid',null)->orWhere('driverid','')->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This Ride is already assigned to other driver";
            $response['data'] = [];
            return $response;
        }
        $driver = driver::whereId($request->driverid)->first();
        $booking = booking::whereId($request->bookingid)->first();
        $src = explode(',',$booking->source);
        $city = app('App\Http\Controllers\api\bookingApiController')->getAddress($src[0],$src[1]);
        $penalty['penalty'] = (float)$driver->penalty;
        if(DB::table('driver_penalty')->where('city',$city)->exists())
        {
            $fine = DB::table('driver_penalty')->where('city',$city)->first();
            $finePenalty = (float)$fine->penalty;
        }
        else
        {
            $finePenalty = 0;
        }
        $penalty['penalty'] = $penalty['penalty']+$finePenalty;
        driver::whereId($request->drievrid)->update($penalty);;
        $user = passengers::whereId($booking->userid)->first();
        if (template::where('type','system')->where('title','Reject Ride')->exists())
        {
            $template = template::where('type','system')->where('title','Reject Ride')->first();
            $message = str_replace('xxx',$finePenalty,$template->message);
            $notification['message'] = $message;
            $notification['image'] = $template->image;
            $notification['title'] = $template->title;
        }
        else
        {
            $notification['message'] = "Penalty of $finePenalty has been charged due to not accepting the Ride Request";
        }
        $notification['driverid'] = $driver->id;
        $notification['type'] = "System";
        driverNotification::create($notification);

        if ($driver->image != '' || !empty($driver->image))
        {
            $driver->image = asset('public/avatars').'/'.$driver->image;
        }
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Booking rejected successfully";
        $response['data'] = $driver;


        $nextDrivers = DB::table('bookingDriver_push')->where('bookingid',$request->bookingid)->first();
        $nextDrivers = explode(',',$nextDrivers->array);
        if (!isset($nextDrivers[0]) || empty($nextDrivers[0]))
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Sorry! Our all drivers are busy at the moment. Try again later";
            $response['data'] = [];

//            ***************************************Code for Push Notification ***************************************

            $title = "Drivers are Busy";
            $pushFor = "Drivers are Busy";
            $token = (string)$user->device_token;
            $body['username'] = $user->fname.' '.$user->lname;
            $msg = "Sorry! Our all drivers are busy at the moment. Try again later";
            $body['message'] = $msg;
            $body['booking_id'] = $booking->id;
            $body['userid'] = $booking->userid;
            $body['phone'] = $booking->phone;
            $body['source'] = $booking->source;
            $body['destination'] = $booking->destination;
            $body['original_price'] = $booking->original_price;
            $body['price'] = $booking->price;
            $body['distance'] = $booking->distance;
            $body['estimated_time'] = $booking->estimated_time;
            $body['title'] = $title;
            $pushNotification = parent::pushNotification($title,$body,$token,$user,$pushFor,$msg,1);
            passengers::whereId($booking->userid)->update(['active_ride'=>0]);
//            *************************************************************************************************************

            return $response;
        }
        foreach ($nextDrivers as $nextDriver)
        {
            $driverNext = explode('-',$nextDriver);
            $drievr[$driverNext[0]] = $driverNext[1];
        }
        $driverid = array_search(max($drievr),$drievr);
        $driver_score = max($drievr);
        $driver = driver::whereId($driverid)->first();
//        *********************************Code for Push Notification *************************************************

        $title = "Ride Request";
        $pushFor = "Accept Ride";
        $token = $driver->device_token;
        $body['username'] = $user->fname.' '.$user->lname;
        $body['user_device_token'] = (string)$user->device_token;
        $msg = "Ride Request";
        $body['message'] = $msg;
        $body['user_rating'] = app('App\Http\Controllers\api\bookingApiController')->getUserRating($user->id);
        $body['booking_id'] = $booking->id;
        $body['userid'] = $booking->userid;
        $body['phone'] = $booking->phone;
        $body['source'] = $booking->source;
        $body['destination'] = $booking->destination;
        $body['original_price'] = $booking->original_price;
        $body['price'] = $booking->price;
        $body['distance'] = $booking->distance;
        $body['estimated_time'] = $booking->estimated_time;
        $body['title'] = $title;
        $pushNotification = parent::pushNotification($title,$body,$token,$driver,$pushFor,$msg,2);
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
        return $response;
    }

    public function PaymentCompleted(Request $request)
    {
        if (driver::whereId($request->drievrid)->where->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be found";
            $response['data'] = [];
            return $response;
        }
        if (booking::whereId($request->bookingid)->where('driverid',$request->drievrid)->exists() ==0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Booking is not assigned to this driver";
            $response['data'] = [];
            return $response;
        }
        booking::whereId($request->bookingid)->where('drievrid',$request->bookingid)->update(['paid'=>1]);
        $booking = booking::whereId($request->bookingid)->first();
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Payment saved Successfully";
        $response['data'] = $booking;
        return $response;
    }

    public function verifyBookingOtp(Request $request)
    {
        if (booking::whereId($request->bookingid)->where('driverid',$request->driverid)->where('otp',$request->otp)->exists())
        {
            $update['status'] = "ongoing";
            $update['trip_start_time'] = new \DateTime();
            booking::whereId($request->bookingid)->update($update);
            $booking = booking::whereId($request->bookingid)->first();
            $user = passengers::whereId($booking->userid)->first();
//            return $user;
            if (isset($booking->image) || ($booking->image != '' || !empty($booking->image)))
            {
                $booking->image = asset('public/avatars').'/'.$booking->image;
            }
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "Great. Your ride is verified!";
            $response['data'] = $booking;

//    ******************************************************Code for Push Notification **************************************

            $title = "Ride Start";
            $pushFor = "Ride Start";
            $token = (string)$user->device_token;
            $body['username'] = $user->fname.' '.$user->lname;
            $body['booking_id'] = $booking->id;
            $body['userid'] = $booking->userid;
            $body['phone'] = $booking->phone;
            $body['source'] = $booking->source;
            $body['destination'] = $booking->destination;
            $body['original_price'] = $booking->original_price;
            $body['price'] = $booking->price;
            $body['distance'] = $booking->distance;
            $body['estimated_time'] = $booking->estimated_time;
            $msg = "Ride Start";
            $body['message'] = $msg;
            $body['title'] = $title;
            $pushNotification = parent::pushNotification($title,$body,$token,$user,$pushFor,$msg,1);

//            **********************************************************************************************
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Invalid Verification Code";
            $response['data'] = [];
        }
        return $response;
    }

    public function reachSource(Request $request)
    {
        if (driver::whereId($request->driverid)->where('status',1)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be found or Driver yet to be Verified!";
            $response['data'] = [];
            return $response;
        }
        if (booking::whereId($request->bookingid)->where('driverid',$request->driverid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Booking is not Associated to this Driver!";
            $response['data'] = [];
            return $response;
        }
        $booking = booking::whereId($request->bookingid)->where('driverid',$request->driverid)->first();
        $driverLatLng = explode(',',$request->driver_lat_lng);
        if ((!isset($driverLatLng[0]) || $driverLatLng[0] == '' || empty($driverLatLng[0])) || (!isset($driverLatLng[1]) || $driverLatLng[1] == '' ||  empty($driverLatLng[1])))
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "Invalid Driver data Received! Format- driver_lat_lng = 'lat,lng'";
            $response['data'] = [];
            return $response;
        }
        $latSrc = $driverLatLng[0];
        $lngSrc = $driverLatLng[1];
        $source = explode(',',$booking->source);
        $latDest = $source[0];
        $lngDest = $source[1];
        $distance = app('App\Http\Controllers\api\bookingApiController')->calculateDistance($latSrc,$lngSrc,$latDest,$lngDest);
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Distance and time Fetched Successfully";
        $response['estimated_distance'] = $distance['distance'].' Km';
        $response['estimated_time'] = $distance['time'];
        $response['data'] = [];
        return $response;
    }

    public function cancellRide(Request $request)
    {
        if (driver::whereId($request->driverid)->where('status',1)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be found or Driver yet to be Verified!";
            $response['data'] = [];
            return $response;
        }
        $driver = driver::whereId($request->driverid)->first();
        if (booking::whereId($request->bookingid)->where('driverid',$request->driverid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Booking is not Associated to this Driver!";
            $response['data'] = [];
            return $response;
        }
        $booking = booking::whereId($request->bookingid)->first();
        if ($booking->cancelled_at == null || empty($booking->cancelled_at))
        {
            $updateBooking['status'] = "cancelled";
            $updateBooking['cancelled_at'] = new \DateTime();
            $updateBooking['cancelled_by'] = "driver";
//            booking::whereId($request->bookingid)->update($updateBooking);
            $booking = booking::whereId($request->bookingid)->first();
            $user = passengers::whereId($booking->userid)->first();
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "Booking cancelled Successfully";
            $response['data'] = $booking;
            passengers::whereId($booking->userid)->update(['active_ride'=>0]);
            driver::whereId($booking->driverid)->update(['active_ride'=>0,'isAvailable'=>1]);
            if (template::where('type','system')->where('title','Booking Cancel')->exists())
            {
                $template = template::where('type','system')->where('title','Booking Cancel')->first();
                $message = str_replace('xxx',$booking->id,$template->message);
                $notification['message'] = $message;
                $notification['image'] = $template->image;
                $notification['title'] = $template->title;
            }
            else
            {
                $notification['message'] = "Your Ride #".$booking->id." is Cancelled";
            }
            $notification['driverid'] = $driver->id;
            $notification['type'] = "System";
            driverNotification::create($notification);

//       ****************************************Code for Push Notification **********************************************

            $title = "Ride Cancel";
            $pushFor = "Ride Cancel";
            $token = $user->device_token;
            $body['username'] = $user->fname.' '.$user->lname;
            $msg = "Ride Cancel";
            $body['message'] = $msg;
            $body['booking_id'] = $booking->id;
            $body['userid'] = $booking->userid;
            $body['phone'] = $booking->phone;
            $body['source'] = $booking->source;
            $body['destination'] = $booking->destination;
            $body['original_price'] = $booking->original_price;
            $body['price'] = $booking->price;
            $body['distance'] = $booking->distance;
            $body['estimated_time'] = $booking->estimated_time;
            $body['title'] = $title;
            $pushNotification = parent::pushNotification($title,$body,$token,$user,$pushFor,$msg,1);

//                ***************************************************************************************
            return $response;
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Booking is already cancelled";
            $response['data'] = $booking;
            return $response;
        }
    }


    public function getUserRating(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
            return $response;
        }
        $count = passenger_rating::where('userid',$request->userid)->count();
        if ($count == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "User has no Rating";
            $response['data'] = [];
            return $response;
        }
        $ratings = passenger_rating::where('userid',$request->userid)->get();
        $rate = 0;
        foreach ($ratings as $rating)
        {
            $rate +=(int)$rating->rating;
        }
        $rate = $rate/$count;
        return number_format($rate,2);
    }

    public function setDiscount(Request $request)
    {
        if (driver::whereId($request->driverid)->where('status',1)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be found";
            $response['data'] = [];
            return $response;
        }
        driver::whereId($request->driverid)->update(['discount'=>$request->discount]);
        $driver = driver::whereId($request->driverid)->first();
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Discount set Successfully";
        $response['data'] = $driver;
        return $response;
    }

    public function getNotifications(Request $request)
    {
        if (driver::whereId($request->driverid)->where('status',1)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be found";
            $response['data'] = [];
            return $response;
        }
        if (driverNotification::where('driverid',$request->driverid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "No notifications Found";
            $response['data'] = [];
            return $response;
        }
        $notifications = driverNotification::where('driverid',$request->driverid)->orderby('id','desc')->get();
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
        if (driver::whereId($request->driverid)->where('status',1)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be found";
            $response['data'] = [];
            return $response;
        }
        if (driverNotification::whereId($request->notification_id)->where('driverid',$request->driverid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Notification not Found";
            $response['data'] = [];
            return $response;
        }
        driverNotification::whereId($request->notification_id)->update(['read',1]);
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Notification updated successfully";
        $response['data'] = [];
        return $response;
    }
    public function deleteNotification(Request $request)
    {
        if (driver::whereId($request->driverid)->where('status',1)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be found";
            $response['data'] = [];
            return $response;
        }
        if (driverNotification::exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Notification not Found";
            $response['data'] = [];
            return $response;
        }
        driverNotification::where('driverid',$request->driverid)->forcedelete();
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Notification deleted successfully";
        $response['data'] = [];
        return $response;
    }

    function driverRating($driverid)
    {
        $ratings = rating::where('driverid',$driverid)->sum('rating');
        $count = rating::where('driverid',$driverid)->count();
        $totalRating = 0;
        if ($count >= 1)
        {
            $totalRating = $ratings/$count;
        }
        return $totalRating;
    }

    public function logout(Request $request)
    {
        if (driver::whereId($request->driverid)->exists())
        {
            driver::whereId($request->driverid)->update(['device_token'=>null,'isAvailable'=>0]);
            $user = driver::whereId($request->driverid)->first();
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "Driver logged out successfully";
            $response['data'] = $user;
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver could not be found";
            $response['data'] = [];
        }
        return $response;
    }
    public function refreshDeviceToken(Request $request)
    {
        if (driver::whereId($request->driverid)->exists())
        {
            driver::whereId($request->driverid)->update(['device_token'=>$request->device_token,'device_type'=>$request->device_type]);
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

    public function abc()
    {
        $j = 6;
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
            return strtoupper($string); //to uppercase

        return strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 6));
    }
    public function checkActiveRide(Request $request)
    {
        if(driver::whereId($request->driverid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['message'] = "Driver doesn't exists";
            $response['status'] = "failed";
            $response['data'] = [];
            return $response;
        }
        $user = driver::whereId($request->driverid)->first();
        if($user->active_ride == 0)
        {
            $response['code'] = 200;
            $response['message'] = "Driver is not actively on ride";
            $response['status'] = "success";
            $response['active_ride'] = 0;
            $response['data'] = [];
            return $response;
        }
        else
        {
            $booking = booking::where('driverid',$request->driverid)->orderby('id','desc')->first();
            $user = User::whereId($booking['userid'])->first();
            $booking['username'] = $user->fname.' '.$user->lname;
            $response['code'] = 200;
            $response['message'] = "Driver is actively on a ride";
            $response['status'] = "success";
            $response['active_ride'] = 1;
            $response['data'] = $booking;
            return $response;
        }
    }

    public function checkSubscription(Request $request)
    {
        if (driver::whereId($request->driverid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Driver doesn't exists";
            $response['data'] = [];
            return $response;
        }
        $driver = driver::whereId($request->driverid)->first();
        if ($driver->status != 1)
        {
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "You will not be getting any rides without getting verified";
            $response['payment'] = 0;
            $response['status'] = 0;
            $response['remaining_day'] = 0;
            $response['data'] = [];
            return $response;
        }
        if ($driver->payment != 1)
        {
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "You will not be getting any rides without paying the subscription";
            $response['payment'] = 0;
            $response['remaining_day'] = 0;
            $response['status'] = 1;
            $response['data'] = [];
            return $response;
        }
        $nextPay = $driver->next_pay;
        $dateDiff = $nextPay - time();
        $days = round($dateDiff/(60*60*24));
        if ($days <= 15)
        {
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "Your subscription will be renewed automatically in ".$days." days. Please cancel the subscription to avoid auto renewal";
            $response['payment'] = 1;
            $response['remaining_day'] = $days;
            $response['status'] = 1;
            $response['data'] = [];
            return $response;
        }
        else
        {
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "Login successfull";
            $response['payment'] = 1;
            $response['status'] = 1;
            $response['data'] = [];
            return $response;
        }
    }

    public function driverDetails(Request $request)
    {
        if (driver::whereId($request->driverid)->exists())
        {
            $user = driver::whereId($request->driverid)->first();
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
            $response['message'] = "This driver doesn’t exist";
            $response['data'] = [];
        }
        return $response;
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
        if (driver::where('id','!=',$request->drievrid)->where('phone',$mNumber)->exists()){
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This mobile number already used by other user.";
            $response['data'] = [];
            return $response;
        }
        if (driver::where('id','!=',$request->drievrid)->where('email',$request->email)->exists())
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This email already used by other user.";
            $response['data'] = [];
            return $response;
        }
        if (driver::whereId($request->userid)->exists() == 0)
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['message'] = "This user doesn’t exist";
            $response['data'] = [];
            return $response;
        }

//        if (isset($request->password) && $request->password != $request->confirm_password)
//        {
//            $response['status'] = "failed";
//            $response['code'] = 500;
//            $response['message'] = "Passwords don’t match";
//            $response['data'] = [];
//            return $response;
//        }

        $update = $request->except('except','password','confirm_password','userid','phone');
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
        driver::whereId($request->userid)->update($update);
        $user = driver::whereId($request->userid)->where('phone',$mNumber)->first();
        unset($user->password);
        if ($user->image != '' || !empty($user->image))
        {
            $user->image = asset('public/avatars').'/'.$user->image;
        }
        else
        {
            $user->image = "";
        }
        $response['status'] = "success";
        $response['code'] = 200;
        $response['message'] = "Saved";
        $response['data'] = $user;

        $reference = $this->database->getReference('user');

        $postData[$user->firebase_key] = [
            'userid' => 'driver_'.$user->id,
            'username'=> $user->fname,
            'usertype'=> 'driver',
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
}
