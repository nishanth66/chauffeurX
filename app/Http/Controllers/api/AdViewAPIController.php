<?php

namespace App\Http\Controllers\api;

use App\Models\adSettings;
use App\Models\advertisement;
use App\Models\AdView;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AdViewAPIController extends Controller
{
    public function updateAdView(Request $request)
    {
        if (advertisement::whereId($request->adId)->exists())
        {
            $advertisemet  = advertisement::whereId($request->adId)->first();
            $city = app('App\Http\Controllers\api\bookingApiController')->getAddress($advertisemet->lat,$advertisemet->lng);
            if (adSettings::where('city','like',$city)->exists())
            {
                $adSetting = adSettings::where('city','like',$city)->first();
                $base_cost = (float)$adSetting->view_cost;
            }
            else
            {
                $base_cost = 0;
            }
            if (AdView::where('adId',$request->adId)->where('ad_user_id',$advertisemet->adUserid)->where('date',date('Y-m-d',time()))->exists())
            {
                $viewDetails = AdView::where('adId',$request->adId)->where('ad_user_id',$advertisemet->adUserid)->where('date',date('Y-m-d',time()))->first();
                $base_view = (int)$viewDetails->base_view;
                $cost = (float)$viewDetails->ad_cost;
                $base_view++;
                $cost = $cost+$base_cost;
                AdView::whereId($viewDetails->id)->update(['base_view'=>$base_view,'ad_cost'=>$cost]);
            }
            else
            {
                $cost = 1*$base_cost;
                AdView::create([
                    'ad_user_id'=>$advertisemet->adUserid,
                    'adId'=>$request->adId,
                    'base_view'=>1,
                    'category_view'=>0,
                    'ad_cost'=>$cost,
                    'date'=>date('Y-m-d',time())
//                    'date'=>date('Y-m-d',strtotime($request->date))
                ]);
            }
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "View Updated";
            $response['data'] = [];
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Ad doesn't exists";
            $response['data'] = [];
        }
        return $response;
    }
    public function updateCategoryAdView(Request $request)
    {
        if (advertisement::whereId($request->adId)->exists())
        {
            $advertisemet  = advertisement::whereId($request->adId)->first();
            $city = app('App\Http\Controllers\api\bookingApiController')->getAddress($advertisemet->lat,$advertisemet->lng);
            if (adSettings::where('city','like',$city)->exists())
            {
                $adSetting = adSettings::where('city','like',$city)->first();
                $cat_cost = (float)$adSetting->category_view_cost;
            }
            else
            {
                $cat_cost = 0;
            }
            if (AdView::where('adId',$request->adId)->where('ad_user_id',$advertisemet->adUserid)->where('date',date('Y-m-d',time()))->exists())
            {
                $viewDetails = AdView::where('adId',$request->adId)->where('ad_user_id',$advertisemet->adUserid)->where('date',date('Y-m-d',time()))->first();
                $cat_view = (int)$viewDetails->base_view;
                $cost = (float)$viewDetails->ad_cost;
                $cost = $cost+$cat_cost;
                $cat_view++;
                AdView::whereId($viewDetails->id)->update(['category_view'=>$cat_view,'ad_cost'=>$cost]);
            }
            else
            {
                $cost = 1*$cat_cost;
                AdView::create([
                    'ad_user_id'=>$advertisemet->adUserid,
                    'adId'=>$request->adId,
                    'base_view'=>0,
                    'category_view'=>1,
                    'ad_cost'=>$cost,
                    'date'=>date('Y-m-d',time())
//                    'date'=>date('Y-m-d',strtotime($request->date))
                ]);
            }
            $response['code'] = 200;
            $response['status'] = "success";
            $response['message'] = "View Updated";
            $response['data'] = [];
        }
        else
        {
            $response['code'] = 500;
            $response['status'] = "failed";
            $response['message'] = "Ad doesn't exists";
            $response['data'] = [];
        }
        return $response;
    }
}
