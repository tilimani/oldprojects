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

/**
 * House Resource
 */
Route::middleware('api')->group(function() {
    Route::get('houses', 'api\HouseController@index');
    // Route::get('houses', 'api\HouseController@index');
    Route::get('houses/city/{city}', 'api\HouseController@indexCity');
    Route::get('houses/{house}', 'api\HouseController@show');
    Route::get('houses/coordinates/{flag?}', 'api\HouseController@allCoordinates');
    Route::get('houses/coordinates/city/{city}', 'api\HouseController@cityCoordinates');
    Route::post('houses', 'api\HouseController@store');
    Route::put('houses/{house}', 'api\HouseController@update');
    Route::delete('houses/{house}', 'api\HouseController@destroy');

    /*
    * Room Resource
    */
    Route::post('rooms','api\RoomController@getRoomsById');


    /**
     * School Resource
     */
    Route::get('schools', 'api\SchoolController@index');
    Route::get('schools/{school}', 'api\SchoolController@show');
    Route::get('schools/neighborhood/{neighborhood}', 'api\SchoolController@neighborhoodSchools');
    Route::post('schools', 'api\SchoolController@store');
    Route::put('schools/{school}', 'api\SchoolController@update');
    Route::delete('schools/{school}', 'api\SchoolController@destroy');

    /**
     * Neighborhood
     */
    Route::get('neighborhoods/{city}','api\NeighborhoodController@indexCity');

    /**
     * GenericInterestPoint
     */
    Route::get('genericInterestPoints', 'api\GenericInterestPointController@index');

    /**
     * SpecificInterestPoint
     */
    Route::get('specificInterestPoints/{city}', 'api\SpecificInterestPointController@index');

    

    /**
     * Message
     */
    Route::get('message/{booking}', 'api\MessagesController@show');
    

    /**
     * Notifications
     */
    Route::get('notification/{user}', 'api\BookingController@index');
    Route::post('notification/{user}', 'api\BookingController@read');
    Route::post('user/notification/read', 'api\BookingController@readNotification');
    
    /**
     * User
     */
    Route::get('user/{user}', 'api\BookingController@user');
    
    /**
     * Booking
     */
    Route::post('booking/accept', 'api\BookingController@acceptBooking');
    Route::post('booking/deny','api\BookingController@denyBooking');
    Route::post('booking/denyAndBlock','api\BookingController@denyAndBlock');
    Route::post('booking/blockAndSuggest','api\BookingController@blockAndSuggest');
    Route::post('booking/available','api\BookingController@setRoomAvailable');


    Route::prefix('v1')->group(function() {
        Route::get('notifications', 'api\BookingController@sendNotifications');
    
        Route::get('verification/{user}', 'api\VerificationController@show');
    
        Route::get('user/qualification/{user}', 'api\QualificationController@qualificationUser');
    
        Route::post('booking/cancel', 'api\BookingController@cancelBooking');

        Route::get('manager/houses/{booking}', 'api\HouseController@getHouses');
        
        Route::get('rooms/house/{house}', 'api\HouseController@getHouseRooms');

        Route::post('changeHouse', 'api\HouseController@changeBookingHouse');
        
        Route::post('notify/changeroom','api\HouseController@sendChangeRoomNotification');

        Route::post('denyroomchange','api\HouseController@denyRoomChange');
        
        Route::post('localization', 'api\LocalizationController@getLocalization');

        Route::get('/payments/{user}', 'api\PaymentsController@getHistory');

        Route::post('/webhook/post', 'ApiMessageController@store');
        
        Route::get('/webhook/get/{from}', 'ApiMessageController@show');
        
        Route::get('/webhook/index', 'ApiMessageController@index');

        Route::get('user/houses/{user}','api\HouseController@getHousesByManager');

    });

    Route::prefix('invitation')->group(function(){
        Route::post('send','api\InvitationController@createInvitation');
        Route::get('show/{invitation}','api\InvitationController@getInvitationById');
        Route::post('accept','api\InvitationController@acceptInvitation');
    });

    Route::prefix('lambda')->group(function() {
        Route::get('ehloworld','api\LambdaController@ehloWorld');
        Route::get('weekly/reminder/manager','api\LambdaController@weeklyReminderForManager');
        Route::get('weekly/pending/payments/manager','api\LambdaController@notifyPendingPaymentsManager');
        Route::get('notfy/booking/police','api\LambdaController@bookingPolice');
        Route::get('notfy/manager/police','api\LambdaController@managerPolice');
        Route::get('notfy/review/police','api\LambdaController@reviewPolice');
    });
});

Route::post('room','api\RoomController@getRoomById');
/**
* City
*/
Route::get('currentCities','api\CityController@getAvailableCities');


Route::get('v1/payment/user/{user}', 'api\PaymentsController@getHistory');
Route::get('v1/payment/{payment}', 'api\PaymentsController@show');

Route::get('v1/houses/landingpage/{flag}', 'api\HouseController@landingpageHouses');