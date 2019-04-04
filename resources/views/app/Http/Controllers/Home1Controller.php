<?php

namespace App\Http\Controllers;

use App\Models\advertisement;
use App\Models\booking;
use App\Models\cencellation;
use App\Models\driver;
use App\Models\driverTips;
use App\Models\favDriver;
use App\Models\invitedFriends;
use App\Models\passengerStripe;
use App\Models\price;
use App\Models\rating;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
class Home1Controller extends Controller
{
    protected $googleMap = "AIzaSyB56Xh1A7HQDPQg_7HxrPTcSNnlpqYavc0";
    //
    public function login(Request $request)
    {
        $mNumber = $request->phone;
        if (User::where('phone',$mNumber)->exists())
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
                $user = User::where('phone',$request->phone)->update(['otp' => $otp]);
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
        if (User::where('phone',$request->phone)->where('otp',$request->otp)->exists())
        {
            $user = User::where('phone',$request->phone)->where('otp',$request->otp)->first();
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
        if (User::where('phone',$mNumber)->exists())
        {
            $user = User::where('phone',$mNumber)->first();
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
            $user = User::whereId($user->id)->update($update);
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
    public function register(Request $request)
    {
        $mNumber = $request->phone;
        if (User::where('phone',$mNumber)->exists())
        {
            $response['status'] = "failed";
            $response['code'] = 500;
            $response['Message'] = "User with This Phone number is already exists";
            $response['data'] = [];
            return $response;
        }
        elseif (User::where('email',$request->email)->exists())
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

            $user = User::create(['phone'=>$mNumber,'otp'=>$otp,'email'=>$request->email]);
            $response['status'] = "Success";
            $response['code'] = 200;
            $response['Message'] = "User Registered Successfully";
            $response['data'] = $user;

        return $response;
    }
    public function editProfile(Request $request)
    {
        if (User::where('phone',$request->phone)->exists())
        {
            $update = $request->all('except','password','confirm_password');
            $user = User::where('phone',$request->phone)->first();
            if($request->hasFile('image'))
            {

                $photoName = rand(1, 777777777) . time() . '.' . $request->image->getClientOriginalExtension();
                $mime = $request->image->getClientOriginalExtension();
                $request->image->move(public_path('avatars'), $photoName);
                $update['image'] = $photoName;

            }
            $update = $request->all('except','password','confirm_password');
            User::where('phone',$request->phone)->update($update);
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

    public function booking(Request $request)
    {
        if (User::whereId($request->userid)->where('phone',$request->phone)->exists())
        {
            $input = $request->except('image');
            $src= explode( ",", $request->source);
            if ( isset( $src[0] ) && isset( $src[1] ) ) {
                $latSrc = $src[0];
                $lonSrc = $src[1];
            } else {
                $response['statusCode'] = 500;
                $response['status']     = 'failed';
                $response['message']    = 'Enter Valid Source Location.';

                return $response;
            }
            $dest = explode( ",", $request->destination );
            if ( isset( $dest[0] ) && isset( $dest[1] ) ) {
                $latDest = $dest[0];
                $lonDest = $dest[1];
            } else {
                $response['statusCode'] = 500;
                $response['status']     = 'failed';
                $response['message']    = 'Enter Valid Destination Location.';

                return $response;
            }
            $distanceTime = $this->calculateDistance($latSrc,$lonSrc,$latDest,$lonDest);
            $input['distance'] = $distanceTime['distance'];
            $input['estimated_time'] = $distanceTime['time'];
            $input['price'] = $this->calculatePrice($request->categoryId,$input['distance']);
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
            $booking = booking::create($input);
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
                    $response['statusCode'] = 500;
                    $response['status']     = 'failed';
                    $response['message']    = 'Enter Valid Source Location.';

                    return $response;
                }
                $dest = explode( ",", $request->destination );
                if ( isset( $dest[0] ) && isset( $dest[1] ) ) {
                    $latDest = $dest[0];
                    $lonDest = $dest[1];
                } else {
                    $response['statusCode'] = 500;
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

    public function allBooking()
    {
        if (booking::exists())
        {
            $bookings = booking::get();
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

    public function driverBookings(Request $request)
    {
        if (driver::whereId($request->driverid)->exists())
        {
            if (booking::where('driverid',$request->driverid)->exists())
            {
                $bookings = booking::where('driverid',$request->driverid)->get();
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['message'] = "Driver Bookings fetched Successfully";
                $response['data'] = $bookings;
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

    public function rideHistory($userid)
    {
        if (User::whereId($userid)->exists())
        {
            $user = User::whereId($userid)->first();
            if (booking::where('userid',$user->id)->where('completed',1)->exists())
            {
                $bookings = booking::where('userid',$user->id)->where('completed',1)->get();
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

    public function favouriteDriver($userid)
    {
        if (User::whereId($userid)->exists())
        {
            $user = User::whereId($userid)->first();
            if (favDriver::where('userid',$user->id)->exists())
            {
                $favourite = favDriver::where('userid',$user->id)->get();
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['Message'] = "User Favourite Driver";
                $response['data'] = $favourite;
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
        if (User::where('phone',$mNumber)->exists())
        {
            $user = User::where('phone',$mNumber)->first();
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

    public function addDriverTips(Request $request)
    {
        if (booking::whereId($request->bookingId)->exists())
        {
            $booking = booking::whereId($request->bookingId)->first();
            if (User::whereId($booking->userid)->exists())
            {
                $booking = booking::whereId($request->bookingId)->update(['driver_tips	'=>$request->driverTips]);
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

    public function addStripeCard(Request $request)
    {
        if (User::whereId($request->userid)->exists() == 0)
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
        $user = User::whereId($request->userid)->first();
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
            User::whereId($user->id)->update(['stripe_id' => $customerId]);
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
        if (User::whereId($request->userid)->exists()==0)
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
        if (User::whereId($request->userid)->exists())
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

    public function cancelBookingFee(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        if (User::whereId($request->userid)->exists())
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
//        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$latSrc.",".$lonSrc."&destinations=".$latDest.",".$lonDest."&mode=driving&language=pl-PL";
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

        return array('distance' => $dist, 'time' => $time);
    }
    function calculatePrice($category,$distance)
    {
        $categoryPrice = price::where('category',$category)->first();
        $categoryPerKM = $categoryPrice->amount;
        $price = $distance*$categoryPerKM;
        return $price;
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
        $response['status'] = "Success";
        $response['code'] = 200;
        $response['Message'] = "Ads saved Successfully";
        $response['data'] = $ads;
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
                $response['status'] = 500;
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
            $response['status'] = 200;
            $response['message'] = "Invitation sent Succesfully";
            $response['data'] = $invited_users;
            return $response;
        }
        else
        {
	        $error['status'] = 500;
	        $error['message'] = "Invitation send Failed";
            return $error;
        }
    }
}
