<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\API\CreatepreferencesAPIRequest;
use App\Http\Requests\API\UpdatepreferencesAPIRequest;
use App\Models\musicPreference;
use App\Models\passengers;
use App\Models\preferences;
use App\Repositories\preferencesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class preferencesController
 * @package App\Http\Controllers\API
 */

class preferencesAPIController extends Controller
{
    public function addPreference(Request $request)
    {
        $input = $request->all();
        if (passengers::whereId($request->userid)->exists() == 0)
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "User not Found";
            $response['data'] = [];
            return $response;
        }
        if (preferences::where('userid',$request->userid)->exists())
        {
            preferences::where('userid',$request->userid)->update($input);
        }
        else
        {
            preferences::create($input);
        }
        $preference = preferences::where('userid',$request->userid)->first();
        $response['code'] = 200;
        $response['status'] = "success";
        $response['message'] = "Preference Saved Successfully";
        $response['data'] = $preference;
        return $response;
    }
    public function getMusicPreference()
    {
        if (musicPreference::exists())
        {
            $music = musicPreference::get();
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "Preferences fetched successfully";
            $response['data'] = $music;
            return $response;
        }
        else
        {
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "No Preference Found";
            $response['data'] = [];
            return $response;
        }
    }
}
