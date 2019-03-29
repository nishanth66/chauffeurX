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
Route::post('/verificationCode', 'api\passengerApiController@login')->name('sendVerification');
Route::post('/verify', 'api\passengerApiController@verify')->name('verify');
Route::post('/profile', 'api\passengerApiController@register')->name('profile');
Route::post('/register', 'api\passengerApiController@register')->name('register');
Route::post('/editProfile', 'api\passengerApiController@editProfile')->name('editProfile');
Route::get('/rideHistory/{id}', 'api\passengerApiController@rideHistory')->name('rideHistory');
Route::get('/favouriteDriver/{id}', 'api\passengerApiController@favouriteDriver')->name('favouriteDriver');
Route::post('/addFavourite', 'api\passengerApiController@addFavourite')->name('addFavourite');
Route::post('/deleteFavourite', 'api\passengerApiController@deleteFavourite')->name('deleteFavourite');
Route::post('/driverDetail', 'api\passengerApiController@driverDetail')->name('driverDetail');
Route::post('/rateRide', 'api\passengerApiController@rateRide')->name('rateRide');
Route::post('/getRideRating', 'api\passengerApiController@getRideRating')->name('getRideRating');
Route::post('/driverRating', 'api\passengerApiController@driverRating')->name('driverRating');
Route::post('/addDriverTips', 'api\passengerApiController@addDriverTips')->name('addDriverTips');
Route::post('/driverTips', 'api\passengerApiController@driverTips')->name('driverTips');
Route::post('/booking', 'api\passengerApiController@booking')->name('booking');
Route::post('/editBooking', 'api\passengerApiController@editBooking')->name('editBooking');
Route::get('/allBooking', 'api\passengerApiController@allBooking')->name('allBooking');
Route::post('/driverBookings', 'api\passengerApiController@driverBookings')->name('driverBookings');
Route::post('/cancelBookingFee', 'api\passengerApiController@cancelBookingFee')->name('cancelBookingFee');
Route::post('/addStripeCard', 'api\passengerApiController@addStripeCard')->name('addStripeCard');
Route::post('/getStripeCards', 'api\passengerApiController@getStripeCards')->name('getStripeCards');

Route::post('/advertisement', 'api\passengerApiController@advertisement')->name('advertisement');

Route::post('/activateCard', 'api\passengerApiController@activateCard')->name('activateCard');

Route::post('/inviteFriends', 'api\passengerApiController@inviteFriends')->name('inviteFriends');
//Route::post('/getDistance1', 'api\passengerApiController@calculateDistance')->name('getDistance');


Route::prefix('driver')->group(function () {
    Route::group(['namespace' => 'driver'], function()
    {
        Route::post('/login', 'api\driverApiController@login')->name('login');
        Route::post('/verify', 'api\driverApiController@verify')->name('verify');
        Route::post('/register', 'api\driverApiController@register')->name('register');
        Route::post('/profile', 'api\driverApiController@profile')->name('profile');
    });
});

Route::resource('examples', 'exampleAPIController');

Route::resource('driver_categories', 'driverCategoryAPIController');