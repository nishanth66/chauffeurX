<?php

namespace App\Http\Controllers\api;

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
            $response['message'] = "Otp Send Failed";
            $response['data'] = $ex->getMessage();
            return $response;
        }
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Otp Sent Successfully";
        $response['number'] = $mNumber;
        $response['data'] = [];
        return $response;
    }
}
