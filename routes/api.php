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

Route::any('/login','ApiController@login');
Route::any('/reset-password','ApiController@reset_password');
Route::any('/report-incidence','ApiController@report');
Route::any('/people-near-by/{id}','ApiController@nearby');
Route::any('/update-location/{user_id}/{lat}/{lng}','ApiController@update_location');
Route::any('/get-location/{user_id}','ApiController@get_location');
/*start head count*/
Route::get('/head-count/{incidence_id}/{user_id}','ApiController@headcount');

/*updated push notification player id*/
Route::get('/update-notification-id/{player_id}/{user_id}','ApiController@add_notification');
Route::get('/get-notifications/{id}','ApiController@notifications');
Route::get('/get-notifications-count/{id}','ApiController@notifications_count');
Route::get('/get-new-notifications','ApiController@get_new_notifications');

Route::get('send-mail/{email}','ApiController@send_mail');

//change password
Route::post('/change-password','ApiController@change_password');