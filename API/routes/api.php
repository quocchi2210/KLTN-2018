<?php

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

Route::group(

  ['prefix' => 'auth']

, function () {

    Route::post('loginJWT', 'AuthController@loginJWT');
    Route::post('logoutJWT', 'AuthController@logoutJWT');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::group(['prefix' => 'store'], function(){
        Route::post('updateProfileStore', "Api\StoreController@updateProfileStore");
    });

});

Route::group(

['middleware' => 'jwt']
, function () {

    Route::group(['prefix' => 'store'], function(){
        Route::post('updateProfileStore', "Api\StoreController@updateProfileStore");
    });

});

Route::group(['middleware' => 'jwt'], function () {
    Route::post('logout', "AuthController@logout");
    Route::put('update', "ProfileController@updateProfile");
    Route::get('profile', "ProfileController@getProfile");
    Route::post('change', "Api\ChangePasswordController@change");
    Route::group(['prefix' => 'store'], function(){
        Route::post('updateProfileStore', "Api\StoreController@updateProfileStore");
    });
});

Route::group(['middleware' => 'checkadmin'], function () {
	Route::get('user', "Api\Admin\DashboardController@getUser");
	Route::get('user/search', "Api\Admin\DashboardController@searchUser");
	Route::get('user/sort', "Api\Admin\DashboardController@sortUser");
	Route::post('user/lock', "Api\Admin\DashboardController@actionUser");
	Route::post('user/role', "Api\Admin\DashboardController@actionAssignUser");
	Route::post('user/create', "Api\Admin\DashboardController@createUser");
	Route::get('user/profile/{id}', "Api\Admin\DashboardController@readProfile");
	Route::put('user/update/{id}', "Api\Admin\DashboardController@updateUserProfile");
	Route::delete('user/delete/{id}', "Api\Admin\DashboardController@deleteUser");
});
Route::post('login', "AuthController@login");
Route::post('register', "Api\RegisterController@register");
Route::post('user/reset', "Api\PasswordResetController@resetUser");
Route::post('admin/reset', "Api\Admin\DashboardController@resetAdmin");




