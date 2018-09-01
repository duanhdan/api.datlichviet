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

Route::post('v1/user/login', 'UserController@login');
Route::post('v1/user/loginFacebook', 'UserController@loginFacebook');
Route::post('v1/user/register', 'UserController@register');
Route::post('v1/user/forgot', 'UserController@forgot');
Route::post('v1/user/verify', 'UserController@verify');

Route::get('v1/', function() {
	return response()->json(['status' => 'success']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function(){
	Route::get('user/', 'UserController@info');
	Route::put('user/', 'UserController@update');
	Route::put('user/avatar', 'UserController@avatar');
	Route::put('user/password', 'UserController@password');
	Route::put('user/device', 'UserController@device');
	Route::get('user/logout', 'UserController@logout');
});