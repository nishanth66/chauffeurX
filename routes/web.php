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

//Route::resource('driverTips', 'driverTipsController');

Route::resource('cencellations', 'cencellationController');

Route::resource('passengerStripes', 'passengerStripeController');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::resource('categories', 'categoriesController');

Route::resource('prices', 'priceController');

Route::resource('prices', 'priceController');

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