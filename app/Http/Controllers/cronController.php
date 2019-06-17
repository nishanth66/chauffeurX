<?php

namespace App\Http\Controllers;

use App\Models\AdView;
use App\Models\driver;
use App\Models\driverPaymentHistory;
use App\Models\advertisement_users;
use App\Models\advertisement;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;

class cronController extends Controller
{
    public function driverSubscription()
    {
        $drivers = driver::where('status', 1)->where('payment', 1)->get();
        $time = time();
        foreach ($drivers as $driver) {
            if ($time < $driver->next_pay) {
                $stripe = Stripe::make(env('STRIPE_SECRET'));
                if (driverPaymentHistory::where('driverid', $driver->id)->orderby('id', 'desc')->exists()) {
                    $driverPayments = driverPaymentHistory::where('driverid', $driver->id)->orderby('id', 'desc')->first();
                    $customerId = $driver->stripeid;
                    $subscriptionId = $driverPayments->stripe_sub;
                    $subscription = $stripe->subscriptions()->find($customerId, $subscriptionId);
                    if ($subscription['status'] == 'active' || $subscription['status'] == 'trialing') {
                        driver::whereId($driver->id)->update(['next_pay' => $subscription['current_period_end']]);
                        $input['driverid'] = $driver->id;
                        $input['amount'] = $subscription['items']['data'][0]['plan']['amount'] / 100;
                        $input['stripe_sub'] = $subscription['id'];
                        driverPaymentHistory::create($input);
                    } else {
                        driver::whereId($driver->id)->update(['payment' => 0]);
                    }
                }
            }
        }
    }

    public function payAdBudget()
    {
        $ads = advertisement::get();
        foreach($ads as $ad)
        {
            if (AdView::where('adId',$ad->id)->where('payment',0)->exists())
            {
                $adBudget = AdView::where('adId',$ad->id)->where('payment',0)->sum('ad_cost');
                if ($adBudget >= 25)
                {
                    $adUser = advertisement_users::whereId($ad->adUserid)->first();
                    $customerId = $adUser->stripeid;
                    $stripe = Stripe::make(env('STRIPE_SECRET'));
                    try
                    {
                        $charge = $stripe->charges()->create([
                            'customer' => $customerId,
                            'currency' => 'USD',
                            'amount'   => $adBudget,
                            'description'   => "Advertisement Cost for the ad $ad->description",
                        ]);
                    }
                    catch (\Exception $e)
                    {
                        continue;
                    }
                    AdView::where('adId',$ad->id)->update(['payment'=>1]);
                }
            }
        }
    }
}
