<?php

namespace App\Http\Controllers\api;


use App\Models\emergencyContacts;
use App\Models\passengers;
use App\Repositories\emergencyContactsRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class emergencyContactsController
 * @package App\Http\Controllers\API
 */

class emergencyContactsAPIController extends Controller
{
    /** @var  emergencyContactsRepository */
    public function addEmergencyContacts(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "User not Found";
            $response['data'] = [];
            return $response;
        }
        $input = $request->all();
        $emergency = emergencyContacts::create($input);
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Emergency contacts added Successfully";
        $response['data'] = $emergency;
        return $response;
    }
    public function fetchEmergencyContacts(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "User not Found";
            $response['data'] = [];
            return $response;
        }
        if (emergencyContacts::where('userid',$request->userid)->exists() == 0)
        {
            $response['code'] =200;
            $response['status'] = "Success";
            $response['message'] = "No emergency contacts Found";
            $response['data'] = [];
            return $response;
        }
        $emergency = emergencyContacts::where('userid',$request->userid)->get();
        $response['code'] =200;
        $response['status'] = "Success";
        $response['message'] = "Emergency contacts Fetched Successfully!";
        $response['data'] = $emergency;
        return $response;
    }
    public function editEmergencyContact(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "User not Found";
            $response['data'] = [];
            return $response;
        }
        if (emergencyContacts::whereId($request->contact_id)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Emergency Contact Not Found";
            $response['data'] = [];
            return $response;
        }
        $input = $request->except('contact_id');
        $emergency = emergencyContacts::whereId($request->contact_id)->update($input);
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Emergency contacts updated Successfully";
        $response['data'] = $emergency;
        return $response;
    }
    public function deleteEmergencyContact(Request $request)
    {
        if (emergencyContacts::whereId($request->contact_id)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Emergency Contact Not Found";
            $response['data'] = [];
            return $response;
        }
        emergencyContacts::whereId($request->contact_id)->forcedelete();
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Emergency Contact Deleted Successfully";
        $response['data'] = [];
        return $response;
    }
}
