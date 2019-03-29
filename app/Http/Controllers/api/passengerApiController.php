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
use App\Models\invitedFriends;
use App\Models\passengers;
use App\Models\passengerStripe;
use App\Models\price;
use App\Models\rating;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
class passengerApiController extends Controller
{
    protected $googleMap = "AIzaSyB56Xh1A7HQDPQg_7HxrPTcSNnlpqYavc0";
    //
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
        if (passengers::where('phone',$mNumber)->exists())
        {
            $user = passengers::where('phone',$mNumber)->first();
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

    public function booking(Request $request)
    {
        if (passengers::whereId($request->userid)->where('phone',$request->phone)->exists())
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

            $response['status'] = "Success";
            $response['code'] = 200;
            $response['estimated_price'] = $input['price'];
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

    public function rideHistory($userid)
    {
        if (passengers::whereId($userid)->exists())
        {
            $user = passengers::whereId($userid)->first();
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
        if (passengers::whereId($userid)->exists())
        {
            $user = passengers::whereId($userid)->first();
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
            if (passengers::whereId($booking->userid)->exists())
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

    public function getCategories()
    {
        $categories = categories::get();
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

    function getAddress(Request $request)
    {
        $lat1 = $request->lat;
        $lon1 = $request->lon;
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat1,$lon1&key=$this->googleMap";
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
        $response_new['status'] = "Success";
        $response_new['code'] = 200;
        $response_new['message'] = "Address fetched Successfully";
        $response_new['address'] = $response_a['results'][0]['formatted_address'];
        return $response_new;
    }

    function assignDriver($driverid)
    {
        $lastRide = $this->getDriverLastRide($driverid);
        echo $lastRide.'<br/>';
        echo $rating = $this->getDriverRating($driverid).'<br/>';
        echo $last7 = $this->driverSevenBookings($driverid).'<br/>';
        echo $penalty = $this->getPenalty($driverid).'<br/>';

        $score = (1/$this->getDriverLastRide($driverid))+($this->getDriverRating($driverid)/10)+($this->driverSevenBookings($driverid)/100)-($this->getPenalty($driverid));
        return $score;
    }

    function getDriverLastRide($driverid)
    {
//        echo locale_get_default();
//       date_default_timezone_set('America/Denver');

        $bookings  = booking::where('driverid',$driverid)->orderby('trip_end_time','desc')->first();
        $lastTrip = strtotime($bookings->trip_end_time);
        $now = time();
        $diff = $now-$lastTrip;
        return $diff;
    }

    function driverSevenBookings($driverid)
    {
        $prev_date = date('d/m/Y',strtotime('-7 days'));
        $today = date('d/m/Y');
        $bookings = DB::select('select COUNT(*) as rides from bookings where driverid='.$driverid.' and deleted_at is null and STR_TO_DATE(`trip_date_time`,"%d/%m/%Y") BETWEEN STR_TO_DATE("'.$prev_date.'","%d/%m/%Y") and STR_TO_DATE("'.$today.'","%d/%m/%Y")');
        foreach ($bookings as $booking)
        {
           $rides = $booking->rides;
           return $rides;
        }
    }

    function getPenalty($driverid)
    {
        $bookings = booking::where('driverid',$driverid)->get();
        $penalty = 0;
        foreach ($bookings as $booking)
        {
            $penalty += (float)$booking->penalty;
        }
        return $penalty;
    }

    function getDriverRating($driverid)
    {
        $count = rating::where('driverid',$driverid)->count();
        $totalRating = rating::where('driverid',$driverid)->sum('rating');
        $rate = (($totalRating/$count)*100)/5;
        return $rate;
    }

    public function getDriversByCategory(Request $request)
    {
        if (categories::whreId($request->categoryid)->exists() == 0)
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Category Not Found";
            $response['data'] = [];
            return $response;
        }
        else
        {
            if (driverCategory::where('categoryid',$request->categoryid)->exists() == 0)
            {
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['message'] = "No drivers are found on this category";
                $response['data'] = [];
                return $response;
            }
            else
            {
                $drivers = DB::select("select d.* from drivers d,driver_categories c where d.id=c.driverid and c.categoryid=$request->categoryid and d.deleted_at is null and c.deleted_at is null");
                $response['status'] = "Success";
                $response['code'] = 200;
                $response['message'] = "Drivers Fetched Successfully";
                $response['data'] = $drivers;
                return $response;
            }
        }
    }

    public function getNearbyDrievrs(Request $request)
    {
        $userDetais = explode('-',$request->user_lat_lng);
        if ((!isset($userDetais[0]) || $userDetais[0] == '' || empty($userDetais[0])) || (!isset($userDetais[1]) || $userDetais[1] == '' ||  empty($userDetais[1])) || (!isset($userDetais[2]) || $userDetais[2] == '' || empty($userDetais[2])))
        {
            $response['status'] = "Failed";
            $response['code'] = 500;
            $response['message'] = "Invalid user data Received! Format- user_lat_lng = 'userid-lat-lng'";
            $response['data'] = [];
            return $response;
        }
        else
        {
            $lat1 = $userDetais[1];
            $long1 = $userDetais[2];
        }
        $drivers = explode(',',$request->driver_lat_lng);
        foreach ($drivers as $driver)
        {
            $details = explode('-',$driver);
            if ((!isset($details[0]) || $details[0] == '' || empty($details[0])) || (!isset($details[1]) || $details[1] == '' || empty($details[1])) || (!isset($details[2]) || $details[2] == '' || empty($details[2])))
            {
                $response['status'] = "Failed";
                $response['code'] = 500;
                $response['message'] = "Invalid driver data Received! Format- driver_lat_long = 'driverid-lat-lng'";
                $response['data'] = [];
                return $response;
            }
            else
            {
                $id = $details[0];
                $lat2 = $details[1];
                $long2 = $details[2];
                if (driver::whereId($id)->exists() == 0)
                {
                    $response['status'] = "Failed";
                    $response['code'] = 500;
                    $response['message'] = "Driver with id = $id not Found";
                    $response['data'] = [];
                    return $response;
                }
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
            else
            {
                $output = $distance;
            }
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "Driver with distance fetched successfully!";
            $response['data'] = $output;
            return $response;
        }
        else
        {
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "No nearby drivers are found with the provided category!";
            $response['data'] = [];
            return $response;
        }

    }



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
    }
}
