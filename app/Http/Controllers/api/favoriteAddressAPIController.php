<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\API\CreatefavoriteAddressAPIRequest;
use App\Http\Requests\API\UpdatefavoriteAddressAPIRequest;
use App\Models\favoriteAddress;
use App\Models\musicPreference;
use App\Models\passengers;
use App\Repositories\favoriteAddressRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class favoriteAddressController
 * @package App\Http\Controllers\API
 */

class favoriteAddressAPIController extends Controller
{
    public function __construct()
    {

    }
    public function addFavoriteAddress(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "User Not Found";
            $response['data'] = [];
            return $response;
        }
        if ((!isset($request->lat) || $request->lat == '' || empty($request->lat)) || (!isset($request->lng) || $request->lng == '' || empty($request->lng)))
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Lattitude and Logitude can not be Empty";
            $response['data'] = [];
            return $response;
        }
        if (favoriteAddress::where('userid',$request->userid)->where('lat',$request->lat)->where('lng',$request->lng)->exists())
        {
            $response['code'] = 500;
            $response['status'] = "success";
            $response['message'] = "This address is already exists!";
            $response['data'] = [];
            return $response;
        }
        $address=app('App\Http\Controllers\api\bookingApiController')->getFormattedAddress($request->lat,$request->lng);
        $input = $request->all();
        $input['address'] = $address;
        $favoriteAddress = favoriteAddress::create($input);
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Address Added Successfully";
        $response['data'] = $favoriteAddress;
        return $response;
    }
    public function fetchFavoriteAddress(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "User Not Found";
            $response['data'] = [];
            return $response;
        }
        if (favoriteAddress::where('userid',$request->userid)->exists() == 0)
        {
            $response['code'] = 200;
            $response['status'] = "Success";
            $response['message'] = "No favorite address Found";
            $response['data'] = [];
            return $response;
        }
        $favoritAddress = favoriteAddress::where('userid',$request->userid)->get();
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Address Fetched Successfully";
        $response['data'] = $favoritAddress;
        return $response;
    }
    public function editFavoriteAddress(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "User Not Found";
            $response['data'] = [];
            return $response;
        }
        if (favoriteAddress::whereId($request->address_id)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Address not Found";
            $response['data'] = [];
            return $response;
        }

        if ((!isset($request->lat) || $request->lat == '' || empty($request->lat)) || (!isset($request->lng) || $request->lng == '' || empty($request->lng)))
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "Lattitude and Logitude can not be Empty";
            $response['data'] = [];
            return $response;
        }

        $address=app('App\Http\Controllers\api\bookingApiController')->getFormattedAddress($request->lat,$request->lng);
        $input = $request->except('address_id');
        $input['address'] = $address;
        $favoriteAddress = favoriteAddress::whereId($request->address_id)->update($input);
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Address Updated Successfully";
        $response['data'] = $favoriteAddress;
        return $response;
    }
    public function deleteFavoriteAddress(Request $request)
    {
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Failed";
            $response['message'] = "User Not Found";
            $response['data'] = [];
            return $response;
        }
        if (favoriteAddress::whereId($request->address_id)->where('userid',$request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "Success";
            $response['message'] = "Address not Found";
            $response['data'] = [];
            return $response;
        }
        favoriteAddress::whereId($request->address_id)->where('userid',$request->userid)->forcedelete();
        $response['code'] = 200;
        $response['status'] = "Success";
        $response['message'] = "Address Deleted Successfully";
        $response['data'] = [];
        return $response;
    }
}
