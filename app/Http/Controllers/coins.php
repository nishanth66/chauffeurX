<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;

class coins extends Controller
{

    public function coinSetting ()
    {
        if (DB::table('coins')->exists())
        {
            $details = DB::table('coins')->first();
            $create = $details->create_account;
            $invite = $details->invite;
            $share = $details->share;
            $add_tip = $details->add_tip;
            $add_fav = $details->add_fav;
            $new_city = $details->new_city;
            $delete_app = $details->delete_app;
            $new_category = $details->new_category;
        }
        else
        {
            $create = 0;
            $invite = 0;
            $share = 0;
            $add_tip = 0;
            $add_fav = 0;
            $new_city = 0;
            $delete_app = 0;
            $new_category = 0;
        }
        if (DB::table('coins_for_trip')->exists())
        {
            $trip = DB::table('coins_for_trip')->first();
            $kilo_meters = $trip->kilo_meters;
            $coins_km = $trip->coins_km;
            $rides = $trip->rides;
            $coins_ride = $trip->coins_ride;
        }
        else
        {
            $kilo_meters = 0;
            $coins_km = 0;
            $rides = 0;
            $coins_ride = 0;
        }
        return view('coins.all',compact('create','invite','share','add_fav','add_tip','new_city','new_category','delete_app','kilo_meters','coins_km','rides','coins_ride'));
    }

    public function savecoinSetting(Request $request)
    {
        $input = $request->except('_token','kilo_meters','coins_km','rides','coins_ride');
        if (DB::table('coins')->exists())
        {
            DB::table('coins')->first()->update($input);
        }
        else
        {
            DB::table('coins')->insert($input);
        }
        $update['kilo_meters'] = $request->kilo_meters;
        $update['coins_km'] = $request->coins_km;
        $update['rides'] = $request->rides;
        $update['coins_ride'] = $request->coins_ride;
        if (DB::table('coins_for_trip')->exists())
        {
            DB::table('coins_for_trip')->first()->update($update);
        }
        else
        {
            DB::table('coins_for_trip')->insert($update);
        }
        return redirect('coins/setting');
    }

    public function createAccountCoins()
    {
        if (DB::table('coins')->exists())
        {
            $details = DB::table('coins')->first();
            if (!isset($details->create_account) || $details->create_account == '' || empty($details->create_account) || $details->create_account == null)
            {
                $coins = 0;
            }
            else
            {
                $coins = $details->create_account;
            }
        }
        else
        {
            $coins = 0;
        }
        return view('coins.create',compact('coins'));

    }


    public function createAccountCoinsSave(Request $request)
    {
        $input['create_account'] = $request->coins;
        if (DB::table('coins')->exists())
        {
            DB::table('coins')->whereId(1)->update($input);
        }
        else
        {
            DB::table('coins')->insert($input);
        }
        Flash::success("Coins Saved Successfully");
        return redirect('createAccountCoins');
    }


    public function invitingCoins()
    {
        if (DB::table('coins')->exists())
        {
            $details = DB::table('coins')->first();
            if (!isset($details->invite) || $details->invite == '' || empty($details->invite) || $details->invite == null)
            {
                $coins = 0;
            }
            else
            {
                $coins = $details->invite;
            }
        }
        else
        {
            $coins = 0;
        }
        return view('coins.invite',compact('coins'));
    }


    public function invitingCoinsSave(Request $request)
    {
        $input['invite'] = $request->coins;
        if (DB::table('coins')->exists())
        {
            DB::table('coins')->whereId(1)->update($input);
        }
        else
        {
            DB::table('coins')->insert($input);
        }
        Flash::success("Coins Saved Successfully");
        return redirect('invitingCoins');
    }


    public function sharingCoins()
    {
        if (DB::table('coins')->exists())
        {
            $details = DB::table('coins')->first();
            if (!isset($details->share) || $details->share == '' || empty($details->share) || $details->share == null)
            {
                $coins = 0;
            }
            else
            {
                $coins = $details->share;
            }
        }
        else
        {
            $coins = 0;
        }
        return view('coins.share',compact('coins'));
    }


    public function sharingCoinsSave(Request $request)
    {
        $input['share'] = $request->coins;
        if (DB::table('coins')->exists())
        {
            DB::table('coins')->whereId(1)->update($input);
        }
        else
        {
            DB::table('coins')->insert($input);
        }
        Flash::success("Coins Saved Successfully");
        return redirect('sharingCoins');
    }


    public function kiloMetreCoins()
    {
        if (DB::table('coins_for_trip')->where('kilo_meters','!=',null)->orWhere('kilo_meters','!=','')->where('coins_km','!=',null)->orWhere('coins_km','!=','')->exists())
        {
            $details = DB::table('coins_for_trip')->first();
            $km = $details->kilo_meters;
            $coins = $details->coins_km;
        }
        else
        {
            $km = 0;
            $coins = 0;
        }
        return view('coins.km',compact('km','coins'));
    }


    public function kiloMetreCoinsSave(Request $request)
    {
        $input['kilo_meters'] = $request->kilo_meters;
        $input['coins_km'] = $request->coins_km;
        if (DB::table('coins_for_trip')->exists())
        {
            DB::table('coins_for_trip')->whereId(1)->update($input);
        }
        else
        {
            DB::table('coins_for_trip')->insert($input);
        }
        Flash::success("Coins Updated Successfully");
        return redirect('kiloMetreCoins');
    }


    public function ridesCoins()
    {
        if (DB::table('coins_for_trip')->where('rides','!=',null)->orWhere('rides','!=','')->where('coins_ride','!=',null)->orWhere('coins_ride','!=','')->exists())
        {
            $details = DB::table('coins_for_trip')->first();
            $rides = $details->rides;
            $coins = $details->coins_ride;
        }
        else
        {
            $rides = 0;
            $coins = 0;
        }
        return view('coins.ride',compact('rides','coins'));
    }


    public function ridesCoinsSave(Request $request)
    {
        $input['rides'] = $request->rides;
        $input['coins_ride'] = $request->coins_ride;
        if (DB::table('coins_for_trip')->exists())
        {
            DB::table('coins_for_trip')->whereId(1)->update($input);
        }
        else
        {
            DB::table('coins_for_trip')->insert($input);
        }
        Flash::success("Coins Updated Successfully");
        return redirect('ridesCoins');
    }


    public function tippingCoins()
    {
        if (DB::table('coins')->exists())
        {
            $details = DB::table('coins')->first();
            if (!isset($details->add_tip) || $details->add_tip == '' || empty($details->add_tip) || $details->add_tip == null)
            {
                $coins = 0;
            }
            else
            {
                $coins = $details->add_tip;
            }
        }
        else
        {
            $coins = 0;
        }
        return view('coins.tip',compact('coins'));
    }


    public function tippingCoinsSave(Request $request)
    {
        $input['add_tip'] = $request->coins;
        if (DB::table('coins')->exists())
        {
            DB::table('coins')->whereId(1)->update($input);
        }
        else
        {
            DB::table('coins')->insert($input);
        }
        Flash::success("Coins Saved Successfully");
        return redirect('tippingCoins');
    }


    public function addFavoriteCoins()
    {
        if (DB::table('coins')->exists())
        {
            $details = DB::table('coins')->first();
            if (!isset($details->add_fav) || $details->add_fav == '' || empty($details->add_fav) || $details->add_fav == null)
            {
                $coins = 0;
            }
            else
            {
                $coins = $details->add_fav;
            }
        }
        else
        {
            $coins = 0;
        }
        return view('coins.fav',compact('coins'));
    }


    public function addFavoriteCoinsSave(Request $request)
    {
        $input['add_fav'] = $request->coins;
        if (DB::table('coins')->exists())
        {
            DB::table('coins')->whereId(1)->update($input);
        }
        else
        {
            DB::table('coins')->insert($input);
        }
        Flash::success("Coins Saved Successfully");
        return redirect('addFavoriteCoins');
    }


    public function newCityCoins()
    {
        if (DB::table('coins')->exists())
        {
            $details = DB::table('coins')->first();
            if (!isset($details->new_city) || $details->new_city == '' || empty($details->new_city) || $details->new_city == null)
            {
                $coins = 0;
            }
            else
            {
                $coins = $details->new_city;
            }
        }
        else
        {
            $coins = 0;
        }
        return view('coins.city',compact('coins'));
    }


    public function newCityCoinsSave(Request $request)
    {
        $input['new_city'] = $request->coins;
        if (DB::table('coins')->exists())
        {
            DB::table('coins')->whereId(1)->update($input);
        }
        else
        {
            DB::table('coins')->insert($input);
        }
        Flash::success("Coins Saved Successfully");
        return redirect('newCityCoins');
    }


    public function deleteAppCoins()
    {
        if (DB::table('coins')->exists())
        {
            $details = DB::table('coins')->first();
            if (!isset($details->delete_app) || $details->delete_app == '' || empty($details->delete_app) || $details->delete_app == null)
            {
                $coins = 0;
            }
            else
            {
                $coins = $details->delete_app;
            }
        }
        else
        {
            $coins = 0;
        }
        return view('coins.delete',compact('coins'));
    }


    public function deleteAppCoinsSave(Request $request)
    {
        $input['delete_app'] = $request->coins;
        if (DB::table('coins')->exists())
        {
            DB::table('coins')->whereId(1)->update($input);
        }
        else
        {
            DB::table('coins')->insert($input);
        }
        Flash::success("Coins Saved Successfully");
        return redirect('deleteAppCoins');
    }


    public function newCategoryCoins()
    {
        if (DB::table('coins')->exists())
        {
            $details = DB::table('coins')->first();
            if (!isset($details->new_category) || $details->new_category == '' || empty($details->new_category) || $details->new_category == null)
            {
                $coins = 0;
            }
            else
            {
                $coins = $details->new_category;
            }
        }
        else
        {
            $coins = 0;
        }
        return view('coins.category',compact('coins'));
    }


    public function newCategoryCoinsSave(Request $request)
    {
        $input['new_category'] = $request->coins;
        if (DB::table('coins')->exists())
        {
            DB::table('coins')->whereId(1)->update($input);
        }
        else
        {
            DB::table('coins')->insert($input);
        }
        Flash::success("Coins Saved Successfully");
        return redirect('newCategoryCoins');
    }
}
