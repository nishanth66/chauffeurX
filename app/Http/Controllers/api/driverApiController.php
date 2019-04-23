<?php

namespace App\Http\Controllers\api;

use App\Models\booking;
use App\Models\categories;
use App\Models\driver;
use App\Models\driverCategory;
use App\Models\passenger_rating;
use App\Models\passengers;
use App\Models\preferences;
use Google\Cloud\Storage\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            $driver = driver::where('email', $email)->first();
            if (Hash::check($password, $driver->password) && $email == $driver->email) {
                $response['code'] = 200;
                $response['status'] = "Success";
                $response['message'] = "User Details Fetched successfully";
                $response['data'] = $driver;
                driver::whereId($driver->id)->update(['device_token' => $request->device_token,'device_type' => $request->device_type]);
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
        return $response;
    }
    
    public function rateRide(Request $request)
    {
        if (booking::whereId($request->bookingId)->where('userid',$request->userid)->exists())
        {
            $booking = booking::whereId($request->bookingId)->where('userid',$request->userid)->first();
            $rate = passenger_rating::create([
                'userid'=>$request->userid,
                'bookingid'=>$request->bookingId,
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

    public function tripStart(Request $request)
    {
        if (booking::whereId($request->bookingid)->exists())
        {
            $update['status'] = "ongoing";
            $update['trip_start_time'] = new \DateTime();
            booking::whereId($request->bookingid)->update($update);
            $booking = booking::whereId($request->bookingid)->first();
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "Updated Successfully";
            $response['data'] = $booking;
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Booking Not found";
            $response['data'] = [];
        }
        return $response;
    }

    public function tripEnd(Request $request)
    {
        if (booking::whereId($request->bookingid)->exists())
        {
            $update['status'] = "completed";
            $update['trip_end_time'] = new \DateTime();
            booking::whereId($request->bookingid)->update($update);
            $booking = booking::whereId($request->bookingid)->first();
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "Updated Successfully";
            $response['data'] = $booking;
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Booking Not found";
            $response['data'] = [];
        }
        return $response;
    }

    public function myBookings(Request $request)
    {
        if (driver::whereId($request->driverid)->exists())
        {
            if (booking::where('driverid',$request->driverid)->exists())
            {
                $bookings = booking::where('driverid',$request->driverid)->get();
                $myBookings = array();
                $toDate = strtotime(str_replace('/','-',$request->date));
                foreach ($bookings as $booking)
                {
                    $date = $booking->created_at;
                    $tripDate = strtotime($date);
                    $tripDate = strtotime(date('d-m-Y',$tripDate));
                    if ($toDate == $tripDate)
                    {
                        array_push($myBookings,$booking);
                    }
                }
                if (empty($myBookings) || count($myBookings) < 1)
                {
                    $response['status'] = "Success";
                    $response['code'] = 200;
                    $response['message'] = "No Bookings found on that day";
                    $response['data'] = [];
                    return $response;
                }
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['message'] = "Driver Bookings fetched Successfully";
                $response['data'] = $myBookings;
            }
            else
            {
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['message'] = "Driver has no assigned bookings";
                $response['data'] = [];
            }
        }
        else
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Driver not Found";
            $response['data'] = [];
        }


        return $response;
    }

    public function waitTime(Request $request)
    {
        if (booking::whereId($request->bookingid)->exists())
        {
            booking::whereId($request->bookingid)->update(['wait_time' => $request->wait_time]);
            $booking = booking::whereId($request->bookingid)->first();
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "Booking updated Successfully";
            $response['data'] = $booking;
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Booking not Found";
            $response['data'] = [];
        }
        return $response;
    }

    public function inviteFriends(Request $request)
    {
        $driverid = $request->driverid;
        if(driver::whereId($driverid)->exists() == 0)
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Driver Not Found";
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
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['message'] = "Invitation send Failed";
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

    public function myCategories(Request $request)
    {
        if (driver::whereId($request->driverid)->exists() == 0)
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Driver not Found";
            $response['data'] = [];
            return $response;
        }
        if (driverCategory::where('driverid',$request->driverid)->exists() == 0)
        {
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "No Category found";
            $response['data'] = [];
            return $response;
        }
        else
        {
            $categories = categories::whereId($request->driverid)->get();
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "Driver category fetched successfully!";
            $response['data'] = $categories;
            return $response;
        }
    }

    public function changeAvailableStatus(Request $request)
    {
        if (driver::whereId($request->driverid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Driver Not Found";
            $response['data'] = [];
            return $response;
        }
        driver::whereId($request->driverid)->update(['isAvailable'=>$request->isAvailable]);
        $driver = driver::whereId($request->driverid)->first();
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Driver available status changed updated successfully";
        $response['data'] = $driver;
        return $response;
    }

    public function acceptBooking(Request $request)
    {
        if (driver::whereId($request->drievrid)->where('status',1)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Driver not Found";
            $response['data'] = [];
            return $response;
        }
        if (booking::whereId($request->bookingid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Booking not Found";
            $response['data'] = [];
            return $response;
        }
        if (booking::whereId($request->bookingid)->where('driverid',null)->orWhere('driverid','')->exists() ==0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Booking has already assigned to other Driver";
            $response['data'] = [];
            return $response;
        }
        booking::whereId($request->bookingid)->update(['driverid'=>$request->driverid,'status'=>'Booking Accepted']);
        $booking = booking::whereId($request->bookingid)->first();
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Booking accepted successfully";
        $response['data'] = $booking;
        return $response;
    }

    public function rejectBooking(Request $request)
    {
        if (driver::whereId($request->driverid)->where('status',1)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Driver not Found";
            $response['data'] = [];
            return $response;
        }
        $penalty['penalty'] = 1;
        driver::whereId($request->drievrid)->update($penalty);
        $driver = driver::whereId($request->driverid)->first();
        if ($driver->image != '' || !empty($driver->image))
        {
            $driver->image = asset('public/avatars').'/'.$driver->image;
        }
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Booking rejected successfully";
        $response['data'] = $driver;


        $nextDrivers = DB::table('bookingDriver_push')->where('bookingid',$request->bookingid)->first();
        $nextDrivers = explode(',',$nextDrivers->array);
        if (count($nextDrivers) < 1)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "No others Drivers are Found";
            $response['data'] = [];
            return $response;
        }
        foreach ($nextDrivers as $nextDriver)
        {
            $driverNext = explode('-',$nextDriver);
            $drievr[$driverNext[0]] = $driverNext[1];
        }
        $driverid = array_search(max($drievr),$drievr);
        $driver_score = max($drievr);
//        *********************************Code for Push Notification *************************************************



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
        if (driver::whereId($request->drievrid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Driver not Found";
            $response['data'] = [];
            return $response;
        }
        if (booking::whereId($request->bookingid)->where('driverid',$request->drievrid)->exists() ==0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Booking not Found";
            $response['data'] = [];
            return $response;
        }
        booking::whereId($request->bookingid)->where('drievrid',$request->bookingid)->update(['paid'=>1]);
        $booking = booking::whereId($request->bookingid)->first();
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Payment saved Successfully";
        $response['data'] = $booking;
        return $response;
    }

    public function verifyBookingOtp(Request $request)
    {
        if (booking::whereId($request->bookingid)->where('phone',$request->phone)->where('otp',$request->otp)->exists())
        {
            $update['status'] = "ongoing";
            $update['trip_start_time'] = new \DateTime();
            booking::whereId($request->bookingid)->update($update);
            $booking = booking::whereId($request->bookingid)->first();
            if (isset($booking->image) || ($booking->image != '' || !empty($booking->image)))
            {
                $booking->image = asset('public/avatars').'/'.$booking->image;
            }
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "OTP verified successfully";
            $response['data'] = $booking;
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Invalid OTP";
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
            $response['message'] = "Driver Not Found for Driver yet to be Verified!";
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
        $driverLatLng = explode('-',$request->driver_lat_lng);
        if ((!isset($driverLatLng[0]) || $driverLatLng[0] == '' || empty($driverLatLng[0])) || (!isset($driverLatLng[1]) || $driverLatLng[1] == '' ||  empty($driverLatLng[1])))
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Invalid Driver data Received! Format- driver_lat_lng = 'lat-lng'";
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
            $response['message'] = "Driver Not Found for Driver yet to be Verified!";
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
        $booking = booking::whereId($request->bookingid)->first();
        if ($booking->cancelled_at == null || empty($booking->cancelled_at))
        {
            $updateBooking['status'] = "cancelled";
            $updateBooking['cancelled_at'] = new \DateTime();
            $updateBooking['cancelled_by'] = "driver";
            booking::whereId($request->bookingid)->update($updateBooking);
            $booking = booking::whereId($request->bookingid)->first();
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "Booking cancelled Successfully";
            $response['data'] = $booking;
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

    public function userPreferences(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "User not Found";
            $response['data'] = [];
            return $response;
        }
        if (preferences::where('userid',$request->userid)->exists() == 0)
        {
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "User has No Preferences";
            $response['data'] = [];
            return $response;
        }
        $preferences = preferences::where('userid',$request->userid)->first();
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "User Preferences Fetched Successfully";
        $response['data'] = $preferences;
        return $response;
    }

}
