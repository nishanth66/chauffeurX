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