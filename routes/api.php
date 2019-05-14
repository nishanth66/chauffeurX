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
Route::post('/logout', 'api\passengerApiController@logout')->name('logout');
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
Route::post('/discountAvailable', 'api\passengerApiController@discountAvailable')->name('discountAvailable');
Route::post('/refreshDeviceToken', 'api\passengerApiController@refreshDeviceToken')->name('refreshDeviceToken');
Route::post('/coinsForTrip', 'api\passengerApiController@coinsForTrip')->name('coinsForTrip');

Route::get('/sendPush/{token}', 'api\passengerApiController@sendPush')->name('sendPush');



//*****************************************************Bookings*******************************************************
Route::post('/rideHistory', 'api\bookingApiController@rideHistory')->name('rideHistory');
Route::post('/rateRide', 'api\bookingApiController@rateRide')->name('rateRide');
Route::post('/getRideRating', 'api\bookingApiController@getRideRating')->name('getRideRating');

Route::post('/confirmBooking', 'api\bookingApiController@booking')->name('booking');
Route::post('/sendBookingOtp', 'api\bookingApiController@sendBookingOtp')->name('sendBookingOtp');
Route::post('/editBooking', 'api\bookingApiController@editBooking')->name('editBooking');
Route::get('/allBooking', 'api\bookingApiController@allBooking')->name('allBooking');
Route::get('/readNotification', 'api\bookingApiController@readNotification')->name('readNotification');

Route::post('/cancelBookingFee', 'api\bookingApiController@cancelBookingFee')->name('cancelBookingFee');
Route::post('/cancelBooking', 'api\bookingApiController@cancelBooking')->name('cancelBooking');
Route::post('/advertisement', 'api\bookingApiController@advertisement')->name('advertisement');
Route::post('/RequestBooking', 'api\bookingApiController@RequestBooking')->name('RequestBooking');
Route::post('/displayPrice', 'api\bookingApiController@displayPrice')->name('displayPrice');
Route::get('/getDriversByFilter', 'api\bookingApiController@getDriversByFilter')->name('getDriversByFilter');
Route::get('/driverBookings/{id}', 'api\bookingApiController@driverBookings')->name('driverBookings');
Route::post('/rideAcceptNotification', 'api\bookingApiController@rideAcceptNotification')->name('rideAcceptNotification');
//Route::get('/rideAcceptNotification/{bookingid}/{userid}', 'api\bookingApiController@rideAcceptNotification')->name('rideAcceptNotification');

Route::post('/getDistance1', 'api\bookingApiController@calculateDistance')->name('getDistance');


Route::post('/getPaymentMethods', 'api\bookingApiController@getPaymentMethods')->name('getPaymentMethods');
Route::post('/getCategories', 'api\bookingApiController@getCategories')->name('getCategories');
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



//*******************************************************************Emergency Contacts ***************************************
Route::post('/addEmergencyContacts', 'api\emergencyContactsAPIController@addEmergencyContacts')->name('addEmergencyContacts');
Route::post('/fetchEmergencyContacts', 'api\emergencyContactsAPIController@fetchEmergencyContacts')->name('fetchEmergencyContacts');
Route::post('/editEmergencyContact', 'api\emergencyContactsAPIController@editEmergencyContact')->name('editEmergencyContact');
Route::post('/deleteEmergencyContact', 'api\emergencyContactsAPIController@deleteEmergencyContact')->name('deleteEmergencyContact');



//****************************************************************Favorite Address *****************************************

Route::post('/addFavoriteAddress', 'api\favoriteAddressAPIController@addFavoriteAddress')->name('addFavoriteAddress');
Route::post('/fetchFavoriteAddress', 'api\favoriteAddressAPIController@fetchFavoriteAddress')->name('fetchFavoriteAddress');
Route::post('/editFavoriteAddress', 'api\favoriteAddressAPIController@editFavoriteAddress')->name('editFavoriteAddress');
Route::post('/deleteFavoriteAddress', 'api\favoriteAddressAPIController@deleteFavoriteAddress')->name('deleteFavoriteAddress');


//*************************************************************Preferences********************************************
Route::get('/getMusicPreference', 'api\preferencesAPIController@getMusicPreference')->name('getMusicPreference');



Route::post('/userPreference', 'api\preferencesAPIController@addPreference')->name('addPreference');




Route::get('/driverRating/{id}', 'api\driverApiController@driverRating')->name('driverRating');
Route::get('/sendPushTest/{id}', 'api\driverApiController@sendPushTest')->name('sendPushTest');

Route::get('/getCity/{lat}/{lng}', 'api\bookingApiController@getAddress')->name('getAddress');





Route::prefix('driver')->group(function () {
    Route::group(['namespace' => 'api'], function()
    {
        Route::post('/login', 'driverApiController@login')->name('login');
        Route::post('/logout', 'driverApiController@logout')->name('logout');
        Route::post('/verify', 'driverApiController@verify')->name('verify');
        Route::post('/register', 'driverApiController@register')->name('register');
        Route::post('/profile', 'driverApiController@profile')->name('profile');
        Route::post('/rateCustomer', 'driverApiController@rateCustomer')->name('rateCustomer');
        Route::post('/verifyBookingOtp', 'driverApiController@verifyBookingOtp')->name('tripStart');
        Route::post('/tripEnd', 'driverApiController@tripEnd')->name('tripEnd');
        Route::post('/rideHistory', 'driverApiController@rideHistory')->name('rideHistory');
        Route::post('/inviteFriends', 'driverApiController@inviteFriends')->name('inviteFriends');
        Route::post('/acceptBooking', 'driverApiController@acceptBooking')->name('acceptBooking');
        Route::post('/rejectBooking', 'driverApiController@rejectBooking')->name('rejectBooking');
        Route::post('/cancellRide', 'driverApiController@cancellRide')->name('cancellRide');
        Route::post('/reachSource', 'driverApiController@reachSource')->name('reachSource');
        Route::post('/PaymentCompleted', 'driverApiController@PaymentCompleted')->name('PaymentCompleted');
        Route::post('/changeAvailableStatus', 'driverApiController@changeAvailableStatus')->name('changeAvailableStatus');
        Route::post('/userPreferences', 'preferencesAPIController@userPreferences')->name('userPreferences');
        Route::post('/getUserRating', 'driverApiController@getUserRating')->name('getUserRating');
        Route::post('/arrived', 'driverApiController@arrived')->name('arrived');
        Route::post('/setDiscount', 'driverApiController@setDiscount')->name('setDiscount');
        Route::post('/refreshDeviceToken', 'driverApiController@refreshDeviceToken')->name('refreshDeviceToken');
        Route::post('/getNotifications', 'driverApiController@getNotifications')->name('getNotifications');
        Route::post('/readNotification', 'driverApiController@readNotification')->name('readNotification');
    });
});

Route::resource('emergency_contacts', 'emergencyContactsAPIController');

Route::resource('favorite_addresses', 'favoriteAddressAPIController');

Route::resource('preferences', 'preferencesAPIController');