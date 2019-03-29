<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/verificationCode', 'Home1Controller@login')->name('sendVerification');
Route::post('/verify', 'Home1Controller@verify')->name('verify');
Route::post('/profile', 'Home1Controller@register')->name('profile');
Route::post('/register', 'Home1Controller@register')->name('register');
Route::post('/editProfile', 'Home1Controller@editProfile')->name('editProfile');
Route::get('/rideHistory/{id}', 'Home1Controller@rideHistory')->name('rideHistory');
Route::get('/favouriteDriver/{id}', 'Home1Controller@favouriteDriver')->name('favouriteDriver');
Route::post('/addFavourite', 'Home1Controller@addFavourite')->name('addFavourite');
Route::post('/deleteFavourite', 'Home1Controller@deleteFavourite')->name('deleteFavourite');
Route::post('/driverDetail', 'Home1Controller@driverDetail')->name('driverDetail');
Route::post('/rateRide', 'Home1Controller@rateRide')->name('rateRide');
Route::post('/getRideRating', 'Home1Controller@getRideRating')->name('getRideRating');
Route::post('/driverRating', 'Home1Controller@driverRating')->name('driverRating');
Route::post('/addDriverTips', 'Home1Controller@addDriverTips')->name('addDriverTips');
Route::post('/driverTips', 'Home1Controller@driverTips')->name('driverTips');
Route::post('/booking', 'Home1Controller@booking')->name('booking');
Route::post('/editBooking', 'Home1Controller@editBooking')->name('editBooking');
Route::get('/allBooking', 'Home1Controller@allBooking')->name('allBooking');
Route::post('/driverBookings', 'Home1Controller@driverBookings')->name('driverBookings');
Route::post('/cancelBookingFee', 'Home1Controller@cancelBookingFee')->name('cancelBookingFee');
Route::post('/addStripeCard', 'Home1Controller@addStripeCard')->name('addStripeCard');
Route::post('/getStripeCards', 'Home1Controller@getStripeCards')->name('getStripeCards');

Route::post('/advertisement', 'Home1Controller@advertisement')->name('advertisement');

Route::post('/activateCard', 'Home1Controller@activateCard')->name('activateCard');

Route::post('/inviteFriends', 'Home1Controller@inviteFriends')->name('inviteFriends');
//Route::post('/getDistance1', 'Home1Controller@calculateDistance')->name('getDistance');
