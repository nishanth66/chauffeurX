<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check())
    {
        return redirect('home');
    }
    else
    {
        $domain = request()->getHost();
        if ($domain == env('driver_domain'))
        {
            $siteKey = env('driver_siteKey');
        }
        else
        {
            $siteKey = env('app_siteKey');
        }
        return view('auth.login',compact('siteKey'));
    }
});

Auth::routes();

Route::get('logout',function () {
    Auth::logout();
    return redirect('login');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('bookings', 'bookingController');

Route::resource('favDrivers', 'favDriverController');

Route::resource('drivers', 'driverController');

Route::resource('ratings', 'ratingController');

Route::resource('cancellations', 'cencellationController');

Route::resource('passengerStripes', 'passengerStripeController');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::resource('categories', 'categoriesController');

Route::resource('prices', 'priceController');

//Route::resource('prices', 'priceController');

Route::resource('passengerApis', 'passengerApiController');

Route::resource('advertisements', 'advertisementController');

Route::resource('invitedFriends', 'invitedFriendsController');

Route::resource('passengers', 'passengersController');

Route::resource('driverApis', 'driverApiController');

Route::resource('passengerRatings', 'passenger_ratingController');

Route::resource('paymentMethod', 'driverTipsController');

Route::resource('maximumDistance', 'maximumDistanceController');

Route::get('ad-distance', 'maximumDistanceController@adIndex');

Route::post('ad-distance/save', 'maximumDistanceController@adSave');

Route::resource('notifications', 'notificationController');

Route::resource('templates', 'templateController');


//**********************************************************************Coins Controller**************************************
Route::get('createAccountCoins', 'coins@createAccountCoins');
Route::post('createSaveCoins', 'coins@createAccountCoinsSave');

Route::get('/coins/setting', 'coins@coinSetting');
Route::post('/coins/setting', 'coins@savecoinSetting');

Route::get('invitingCoins', 'coins@invitingCoins');
Route::post('inviteSaveCoins', 'coins@invitingCoinsSave');

Route::get('sharingCoins', 'coins@sharingCoins');
Route::post('shareSaveCoins', 'coins@sharingCoinsSave');

Route::get('kiloMetreCoins', 'coins@kiloMetreCoins');
Route::post('kmSaveCoins', 'coins@kiloMetreCoinsSave');

Route::get('ridesCoins', 'coins@ridesCoins');
Route::post('rideSaveCoins', 'coins@ridesCoinsSave');

Route::get('tippingCoins', 'coins@tippingCoins');
Route::post('tipSaveCoins', 'coins@tippingCoinsSave');

Route::get('addFavoriteCoins', 'coins@addFavoriteCoins');
Route::post('favSaveCoins', 'coins@addFavoriteCoinsSave');

Route::get('newCityCoins', 'coins@newCityCoins');
Route::post('citySaveCoins', 'coins@newCityCoinsSave');

Route::get('deleteAppCoins', 'coins@deleteAppCoins');
Route::post('deleteSaveCoins', 'coins@deleteAppCoinsSave');

Route::get('newCategoryCoins', 'coins@newCategoryCoins');
Route::post('categorySaveCoins', 'coins@newCategoryCoinsSave');

Route::resource('ranks', 'rankController');

Route::get('abc','api\driverApiController@abc');

Route::get('changeCity/{city}/{code}','driverController@changeCity');
Route::get('changeCategoryCity/{city}','categoriesController@changeCity');
Route::get('changePaymentCity/{city}','driverTipsController@changeCity');
Route::get('changeData/{val}','driverController@changeData');
Route::get('category/delete/{id}','categoriesController@delete');
Route::get('fetchCityCategory/{city}','priceController@fetchCityCategory');


Route::prefix('driver/')->group(function () {
//    login/register
    Route::get('home','driverController@home');
    Route::get('delete','driverController@delete');
    Route::get('approved','driverController@index');
    Route::get('pending','driverController@pending');
    Route::get('rejected','driverController@rejected');
    Route::get('register','frontEnd@driverRegister');
    Route::get('login','frontEnd@login');

//    verify
    Route::get('verify','driverController@verification');
    Route::post('verify','driverController@verifyOtp');
    Route::get('resendOtp','driverController@resendOtp');

//    basic details
    Route::get('profile','driverController@profile');
    Route::post('profile','driverController@saveProfile');

//    address
    Route::get('address','driverController@address');
    Route::post('address','driverController@saveAddress');

    Route::get('verifyLicence','driverController@verifyLicence');
    Route::post('verifyLicence','driverController@SaveverifyLicence');

    Route::get('documents','driverController@documents');
    Route::post('documents','driverController@savedocuments');

    Route::get('agree','driverController@agree');
    Route::post('agree','driverController@saveAgree');

    Route::get('SubmitDocument','driverController@SubmitDocument');

    Route::get('licence/{id}','driverController@licenceDetails');

    Route::get('accept/{id}','driverController@accept');

    Route::get('reject/{id}','driverController@reject');

    Route::get('fromToDate/{from}/{to}/{driverid}','driverController@fromToDate');


//    home pages
    Route::get('editProfile','driverController@editProfile');
    Route::get('history','driverController@history');
    Route::get('upcoming','driverController@upcoming');
    Route::post('upcoming','driverController@saveUpcoming');
    Route::get('account','driverController@account');
    Route::post('editProfile','driverController@SaveeditProfile');
});
Route::prefix('advertisement/')->group(function () {

    Route::get('register', 'frontEnd@adRegister');
    Route::post('register', 'frontEnd@SaveadRegister');
    Route::get('login','frontEnd@login');

    Route::get('verify','advertisementController@verify');
    Route::get('resendOtp','advertisementController@resendOtp');
    Route::post('verify','advertisementController@verifyOtp');

    Route::get('profile','advertisementController@profile');
    Route::post('profile','advertisementController@saveProfile');

    Route::get('address','advertisementController@address');
    Route::post('address','advertisementController@saveAddress');

    Route::get('gettingStarted','advertisementController@gettingStarted');


    Route::get('home','advertisementController@home');

});



Route::resource('penalty','penaltyController');
Route::resource('musicPreferences', 'musicPreferenceController');
Route::resource('availableCities', 'availableCitiesController');

Route::resource('pricePerMinutes', 'pricePerMinuteController');



Route::resource('basicFares', 'basicFareController');

Route::resource('minimumFares', 'minimumFareController');

Route::resource('serviceFees', 'serviceFeeController');


Route::get('fireBase', 'affiliateStripeController@fireBase');
Route::get('calculateDistance/{lat1}/{lon1}/{lat2}/{lon2}', 'api\bookingApiController@calculateDistance');


Route::resource('driverStripes', 'driverStripeController');

Route::resource('passengerPayments', 'passengerPaymentController');

Route::resource('driverPayments', 'driverPaymentController');