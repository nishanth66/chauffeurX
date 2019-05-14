<?php

namespace App\Http\Controllers\api;

use Edujugon\PushNotification\PushNotification;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function sendOtp($sid,$token,$mNumber,$otp)
    {
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
            $response['message'] = "Verification Code could not be sent";
            $response['data'] = $ex->getMessage();
            return $response;
        }
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Verification code sent Successfully";
        $response['number'] = $mNumber;
        $response['data'] = [];
        return $response;
    }

    public function pushNotification($title,$body,$token,$user,$pushFor)
    {
        $push = new PushNotification( $user->device_type );
        if ($user->device_type == 'apn' || $user->device_type == 'APN')
        {
            $message=$push->setMessage( [
                'aps' => [
                    'alert' => [
                        'title' => $title,
                        'body'  => $body,
                        'pushFor' => $pushFor
                    ],
                    'sound' => 'default',
                    'badge' => 1

                ]
            ] )
                ->setDevicesToken( $token )
                ->send()->getFeedback();

        }
        else
        {
            $push->setConfig([
                'priority' => 'high'
            ]);
            $message = $push->setMessage([
                'notification' => [
                    'title'=>$title,
                    'body'=>$body,
                    'pushFor' => $pushFor,
                    'sound' => 'default'
                ]
            ])
                ->setApiKey('AIzaSyD1a4xgqMOan0hCbb5itVOkjBKyCD7A8Gc')
                ->setDevicesToken($token)
                ->send()
                ->getFeedback();
        }
        return $message;

    }

}
