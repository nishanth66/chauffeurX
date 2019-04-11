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

//**********************************************************User Profiles *******************************************
Route::post('/verificationCode', 'api\passengerApiController@login')->name('sendVerification');
Route::post('/verify', 'api\passengerApiController@verify')->name('verify');
Route::post('/userDetails', 'api\passengerApiController@userDetails')->name('userDetails');
Route::post('/profile', 'api\passengerApiController@profile')->name('profile');
Route::post('/changePhoneNumber', 'api\passengerApiController@changePhoneNumber')->name('changePhoneNumber');
Route::post('/verifyNewPhoneNumber', 'api\passengerApiController@verifyNewPhoneNumber')->name('verifyNewPhoneNumber');
Route::post('/register', 'api\passengerApiController@register')->name('register');
Route::post('/getStripeCards', 'api\passengerApiController@getStripeCards')->name('getStripeCards');
Route::post('/getNotifications', 'api\passengerApiController@getNotifications')->name('getNotifications');
Route::post('/activateCard', 'api\passengerApiController@activateCard')->name('activateCard');
Route::post('/inviteFriends', 'api\passengerApiController@inviteFriends')->name('inviteFriends');
Route::post('/addStripeCard', 'api\passengerApiController@addStripeCard')->name('addStripeCard');




//*****************************************************Bookings*******************************************************
Route::post('/rideHistory', 'api\bookingApiController@rideHistory')->name('rideHistory');
Route::post('/rateRide', 'api\bookingApiController@rateRide')->name('rateRide');
Route::post('/getRideRating', 'api\bookingApiController@getRideRating')->name('getRideRating');

Route::post('/confirmBooking', 'api\bookingApiController@booking')->name('booking');
Route::post('/sendBookingOtp', 'api\bookingApiController@sendBookingOtp')->name('sendBookingOtp');
Route::post('/editBooking', 'api\bookingApiController@editBooking')->name('editBooking');
Route::get('/allBooking', 'api\bookingApiController@allBooking')->name('allBooking');

Route::post('/cancelBookingFee', 'api\bookingApiController@cancelBookingFee')->name('cancelBookingFee');
Route::post('/cancelBooking', 'api\bookingApiController@cancelBooking')->name('cancelBooking');
Route::post('/advertisement', 'api\bookingApiController@advertisement')->name('advertisement');
Route::post('/RequestBooking', 'api\bookingApiController@RequestBooking')->name('RequestBooking');
Route::post('/displayPrice', 'api\bookingApiController@displayPrice')->name('displayPrice');
Route::get('/getDriversByFilter', 'api\bookingApiController@getDriversByFilter')->name('getDriversByFilter');
Route::get('/driverBookings/{id}', 'api\bookingApiController@driverBookings')->name('driverBookings');

Route::post('/getDistance1', 'api\bookingApiController@calculateDistance')->name('getDistance');

Route::get('/getPaymentMethods', 'api\bookingApiController@getPaymentMethods')->name('getPaymentMethods');
Route::get('/getCategories', 'api\bookingApiController@getCategories')->name('getCategories');
Route::post('/validatePromoCode', 'api\bookingApiController@validatePromoCode')->name('validatePromoCode');
Route::post('/fetchNearbyAds', 'api\bookingApiController@fetchNearbyAds')->name('fetchNearbyAds');
Route::get('/getFormattedAddress/{id1}/{id2}', 'api\bookingApiController@getFormattedAddress')->name('getFormattedAddress');
Route::get('/driverSevenBookings/{id}', 'api\bookingApiController@driverSevenBookings')->name('driverSevenBookings');
Route::get('/calculateDistance/{id1}/{id2}/{id3}/{id4}', 'api\bookingApiController@calculateDistance')->name('calculateDistance');


//**********************************************FavoriteDriver********************************************************
Route::get('/favouriteDriver/{id}', 'api\favDriverApiController@favouriteDriver')->name('favouriteDriver');
Route::post('/addFavourite', 'api\favDriverApiController@addFavourite')->name('addFavourite');
Route::post('/deleteFavourite', 'api\favDriverApiController@deleteFavourite')->name('deleteFavourite');


//*****************************************Booking Driver **********************************************************

Route::post('/driverRating', 'api\bookingDriverApiController@driverRating')->name('driverRating');
Route::post('/addDriverTips', 'api\bookingDriverApiController@addDriverTips')->name('addDriverTips');
Route::post('/driverTips', 'api\bookingDriverApiController@driverTips')->name('driverTips');
Route::post('/driverBookings', 'api\bookingDriverApiController@driverBookings')->name('driverBookings');
Route::post('/getNearbyDrievrs', 'api\bookingDriverApiController@getNearbyDrievrs')->name('getNearbyDrievrs');
Route::post('/driverDetail', 'api\bookingDriverApiController@driverDetail')->name('driverDetail');
Route::get('/assignDriver/{id}/{lat}/{long}', 'api\bookingApiController@assignDriver')->name('assignDriver');
Route::get('/getDriverWaitTime/{id}/{lat}/{long}', 'api\bookingApiController@getDriverWaitTime')->name('getDriverWaitTime');
Route::get('/getDriverRating/{id}', 'api\bookingApiController@getDriverRating')->name('getDriverRating');
Route::get('/getPenalty/{id}', 'api\bookingApiController@getPenalty')->name('getPenalty');





Route::get('/whatsappDemo', 'api\passengerApiController@whatsappDemo')->name('whatsappDemo');
Route::get('/twilioDemo', 'api\passengerApiController@twilioDemo')->name('twilioDemo');
Route::post('/generateChat', 'api\passengerApiController@generateChat')->name('generateChat');




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

Route::resource('emergency_contacts', 'emergencyContactsAPIController');