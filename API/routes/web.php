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
	return view('welcome');
});

Route::get('send-message', 'RedisController@index');
Route::post('send-message', 'RedisController@postSendMessage');

Route::get('map_test', function () {
	return view('map_test');
});