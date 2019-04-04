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
Route::post('/userDetails', 'api\passengerApiController@userDetails')->name('userDetails');
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
Route::post('/confirmBooking', 'api\passengerApiController@booking')->name('booking');
Route::post('/editBooking', 'api\passengerApiController@editBooking')->name('editBooking');
Route::get('/allBooking', 'api\passengerApiController@allBooking')->name('allBooking');
Route::post('/driverBookings', 'api\passengerApiController@driverBookings')->name('driverBookings');
Route::post('/cancelBookingFee', 'api\passengerApiController@cancelBookingFee')->name('cancelBookingFee');
Route::post('/cancelBooking', 'api\passengerApiController@cancelBooking')->name('cancelBooking');
Route::post('/addStripeCard', 'api\passengerApiController@addStripeCard')->name('addStripeCard');
Route::post('/getStripeCards', 'api\passengerApiController@getStripeCards')->name('getStripeCards');

Route::post('/advertisement', 'api\passengerApiController@advertisement')->name('advertisement');

Route::post('/activateCard', 'api\passengerApiController@activateCard')->name('activateCard');
Route::post('/RequestBooking', 'api\passengerApiController@RequestBooking')->name('RequestBooking');
Route::post('/displayPrice', 'api\passengerApiController@displayPrice')->name('displayPrice');

Route::post('/inviteFriends', 'api\passengerApiController@inviteFriends')->name('inviteFriends');


Route::get('/getDriversByFilter', 'api\passengerApiController@getDriversByFilter')->name('getDriversByFilter');

Route::get('/driverBookings/{id}', 'api\passengerApiController@driverBookings')->name('driverBookings');
Route::get('/getPenalty/{id}', 'api\passengerApiController@getPenalty')->name('getPenalty');
Route::post('/getDistance1', 'api\passengerApiController@calculateDistance')->name('getDistance');
Route::post('/getAddress', 'api\passengerApiController@getAddress')->name('getAddress');
Route::get('/getDriverLastRide/{id}', 'api\passengerApiController@getDriverLastRide')->name('getDriverLastRide');
Route::get('/getDriverRating/{id}', 'api\passengerApiController@getDriverRating')->name('getDriverRating');
Route::get('/assignDriver/{id}', 'api\passengerApiController@assignDriver')->name('assignDriver');
Route::get('/getPaymentMethods', 'api\passengerApiController@getPaymentMethods')->name('getPaymentMethods');
Route::get('/getCategories', 'api\passengerApiController@getCategories')->name('getCategories');
Route::post('/getNearbyDrievrs', 'api\passengerApiController@getNearbyDrievrs')->name('getNearbyDrievrs');
Route::post('/validatePromoCode', 'api\passengerApiController@validatePromoCode')->name('validatePromoCode');
//Route::post('/getNearbyDrievrs', 'api\passengerApiController@getNearbyDrievrs')->name('getNearbyDrievrs');
Route::get('/whatsappDemo', 'api\passengerApiController@whatsappDemo')->name('whatsappDemo');

Route::prefix('driver')->group(function () {
    Route::group(['namespace' => 'api'], function()
    {
        Route::post('/login', 'driverApiController@login')->name('login');
        Route::post('/verify', 'driverApiController@verify')->name('verify');
        Route::post('/register', 'driverApiController@register')->name('register');
        Route::post('/profile', 'driverApiController@profile')->name('profile');
        Route::post('/rateRide', 'driverApiController@rateRide')->name('rateRide');
        Route::post('/tripStart', 'driverApiController@tripStart')->name('tripStart');
        Route::post('/tripEnd', 'driverApiController@tripEnd')->name('tripEnd');
        Route::post('/myBookings', 'driverApiController@myBookings')->name('myBookings');
        Route::post('/waitTime', 'driverApiController@waitedTime')->name('waitedTime');
        Route::post('/myCategories', 'driverApiController@myCategories')->name('myCategories');
        Route::post('/inviteFriends', 'driverApiController@inviteFriends')->name('inviteFriends');
        Route::post('/acceptBooking', 'driverApiController@acceptBooking')->name('acceptBooking');
        Route::post('/PaymentCompleted', 'driverApiController@PaymentCompleted')->name('PaymentCompleted');
        Route::post('/changeAvailableStatus', 'driverApiController@changeAvailableStatus')->name('changeAvailableStatus');
    });
});