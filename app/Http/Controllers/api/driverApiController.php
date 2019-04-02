<?php

namespace App\Http\Controllers\api;

use App\Models\booking;
use App\Models\categories;
use App\Models\driver;
use App\Models\driverCategory;
use App\Models\passenger_rating;
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
                driver::whereId($driver->id)->update(['device_token' => $request->device_token]);
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

    public function verify(Request $request)
    {

    }

    public function register(Request $request)
    {

    }

    public function profile(Request $request)
    {
        if (driver::whereId($request->driverid)->exists())
        {
            $update = $request->except('categoryid','payment_methid_id');
            if (isset($request->categoryid) && ($request->categoryid != '' || !empty($request->categoryid)))
            {
                $inputCategory['driverid'] = $request->driverid;
                $inputCategory['categoryid'] = $request->categoryid;
                driverCategory::create($inputCategory);
            }
            if (isset($request->payment_methid_id) && ($request->payment_methid_id != '' || !empty($request->payment_methid_id)))
            {
                $inputPayment['driverid'] = $request->driverid;
                $inputPayment['payment_methid_id'] = $request->payment_methid_id;
                DB::table('driver_payment_method')->insert($inputPayment);
            }
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['message'] = "Driver Updated Successfully!";
            $response['data'] = driver::whereId($request->driverid)->first();
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

                    $date = explode(' ',$booking->trip_date_time);
                    $tripDate = strtotime(str_replace('/','-',$date[0]));
                    if ($toDate == $tripDate)
                    {
                        array_push($myBookings,$booking);
                    }
                }
                if (empty($myBookings))
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

}
