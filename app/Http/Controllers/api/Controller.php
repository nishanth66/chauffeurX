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
    public function sendOtp($sid,$token,$mNumber,$otp,$text)
    {
        $twilio = new Client($sid, $token);
        try
        {
            $message = $twilio->messages
                ->create($mNumber, // to
                    array("from" => "+19562759175",
                        "body" => $text.": ".$otp
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

    public function pushNotification($title,$body,$token,$user,$pushFor,$msg,$app)
    {
        $push = new PushNotification($user->device_type);
        if ($user->device_type == 'apn' || $user->device_type == 'APN') {
            if ($app == 2)
            {
                $push->setConfig([
                    'certificate' => __DIR__ .'/iosCertificate/driver_cer.pem'
                ]);
            }
            else
            {
                $push->setConfig([
                    'certificate' => __DIR__ .'/iosCertificate/passenger.pem'
                ]);
            }

//            $va= array('aps' => [
//                'alert' => [
//                    'title' => $title,
//                    'body' => $body,
//                    'pushFor' => $pushFor
//                ],
//                'sound' => 'default',
//                'badge' => 1
//
//            ]);
            $message = $push->setMessage([
                'aps' => [
                    'alert' => [
                        'title' => $title,
                        'body' => $body,
                        'pushFor' => $pushFor
                    ],
                    'sound' => 'default',
                    'badge' => 1

                ]
            ])
                ->setDevicesToken($token)
                ->send()->getFeedback();

        } else {

            $push->setConfig([
                'priority' => 'high'
            ]);
            $body['title']=$title;
            $message = $this->push_notification_android($token,$title,$msg,$body);

        }
        return $message;
    }
    public function push_notification_android($device_id,$title,$message,$body){

        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';

        /*api_key available in:
        Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
        $api_key = 'AIzaSyD1a4xgqMOan0hCbb5itVOkjBKyCD7A8Gc';

        $fields = array (
            'registration_ids' => array (
                $device_id
            ),
            'data' => $body,
            'priority' => 'high'
        );

//        echo json_encode($fields);
        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
//        if ($result === FALSE) {
//           return $result
//        }
        curl_close($ch);
        return $result;
    }
}
