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

Route::get('/login','AdminController@login')->name('login');


Route::get('/response/{type}','HomeController@response_handler')->name('response');
Route::post('/response/{type}','HomeController@response_store')->name('response');
Route::get('/upload/{incidence}','HomeController@upload')->name('upload');
Route::post('/upload/{incidence}','HomeController@upload_store')->name('upload');

//admin routes

Route::get('/admin/login','AdminController@login');
Route::post('/admin/login','AdminController@Authenticate');

Route::group(['middleware'=>'auth'],function(){
    Route::get('/','AdminController@dashboard');
    Route::get('/home', 'AdminController@dashboard')->name('home');
    Route::get('/admin/dashboard','AdminController@dashboard')->name('admin.dashboard');
    Route::get('/admin/users','AdminController@users');
    Route::get('/admin/reports/{filter?}','AdminController@reports');
    Route::get('/admin/report/{id}','AdminController@single_report');
    
    Route::post('admin/reports/filtered','AdminController@date_filter');
    
    //headcount
    
    Route::get('/admin/headcount','AdminController@headcount')->name('headcount');
    
    //heat map
    
    Route::get('/admin/heatmap','AdminController@heatmap')->name('heatmap');
    
    //staff members location
    Route::get('/admin/staff-location','AdminController@staff_location')->name('staff_location');
    
    Route::post('import','AdminController@import')->name('import');
    Route::get('user-export','AdminController@user_export')->name('user.export');
    Route::get('incident-export','AdminController@incident_export')->name('incident.export');
    Route::get('response-export','AdminController@response_export')->name('response.export');
});
Auth::routes();