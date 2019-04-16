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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('bookings', 'bookingController');

Route::resource('favDrivers', 'favDriverController');

Route::resource('drivers', 'driverController');

Route::resource('ratings', 'ratingController');

Route::resource('cencellations', 'cencellationController');

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

Route::resource('driverDistance', 'maximumDistanceController');

Route::get('ad-distance', 'maximumDistanceController@adIndex');

Route::post('ad-distance/save', 'maximumDistanceController@adSave');

Route::resource('filters', 'filterController');

Route::get('fireBaseDemo', 'fireBaseController@fireBaseDemo');

Route::resource('notifications', 'notificationController');

Route::resource('templates', 'templateController');


//**********************************************************************Coins Controller**************************************
Route::get('createAccountCoins', 'coins@createAccountCoins');
Route::post('createSaveCoins', 'coins@createAccountCoinsSave');

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


Route::prefix('driver/')->group(function () {
//    login/register
    Route::get('register','frontEnd@register');
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



    Route::get('SubmitDocument','frontEnd@SubmitDocument');

    Route::get('profile/5',function () {
        return view('drivers.FrontEnd.profile_5');
    });
    Route::get('profile/8',function () {
        return view('drivers.FrontEnd.profile_8');
    });
});

Route::resource('musicPreferences', 'musicPreferenceController');