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

Route::group(['middleware' => 'jwt'], function () {
	Route::post('logout', "AuthController@logout");
	Route::put('update', "ProfileController@updateProfile");
	Route::get('profile', "ProfileController@getProfile");
	Route::post('change', "Api\ChangePasswordController@change");

});

Route::group(['prefix' => 'shipper'], function () {
	Route::post('showOrder', "Api\ShipperController@showOrder");
	Route::post('showOrderReceived', "Api\ShipperController@showOrderReceived");
	Route::post('showHistory', "Api\ShipperController@showHistory");
	Route::post('updateStatus', "Api\ShipperController@updateStatus");
	Route::post('showDetailOrder', "Api\ShipperController@showDetailOrder");
	Route::post('showAllStoreOrder', "Api\ShipperController@showAllStoreOrder");
	Route::post('getDirection', "Api\ShipperController@getDirection");
	Route::post('checkOrderShipper', "Api\ShipperController@checkOrderShipper");
});
Route::group(['middleware' => 'encrypt'], function () {
	Route::group(['prefix' => 'store'], function () {
		Route::post('updateProfileStore', "Api\StoreController@updateProfileStore");
		Route::post('showProfileStore', "Api\StoreController@showProfileStore");
		Route::post('insertProfileStore', "Api\StoreController@insertProfileStore");

		Route::post('showOrder', "Api\StoreController@showOrder");
		Route::post('showDetailOrder', "Api\StoreController@showDetailOrder");
		
		Route::post('insertOrderStore', "Api\StoreController@insertOrderStore");

		Route::post('updateOrderStore', "Api\StoreController@updateOrderStore");
		Route::post('deleteOrderStore', "Api\StoreController@deleteOrderStore");
		Route::post('getInfoEditFromIdorder', "Api\StoreController@getInfoEditFromIdorder");

	});
});

Route::group(['prefix' => 'ordertrakings'], function () {
	Route::post('insertPosition', "Api\OrderTrakingsController@insertPosition");
	Route::post('updatePosition', "Api\OrderTrakingsController@updatePosition");
});

//Route::group(['middleware' => 'checkadmin'], function () {
//	Route::get('user', "Api\Admin\DashboardController@getUser");
//	Route::get('user/search', "Api\Admin\DashboardController@searchUser");
//	Route::get('user/sort', "Api\Admin\DashboardController@sortUser");
//	Route::post('user/lock', "Api\Admin\DashboardController@actionUser");
//	Route::post('user/role', "Api\Admin\DashboardController@actionAssignUser");
//	Route::post('user/create', "Api\Admin\DashboardController@createUser");
//	Route::get('user/profile/{id}', "Api\Admin\DashboardController@readProfile");
//	Route::put('user/update/{id}', "Api\Admin\DashboardController@updateUserProfile");
//	Route::delete('user/delete/{id}', "Api\Admin\DashboardController@deleteUser");
//});
Route::post('login', "AuthController@login");
Route::post('register', "Api\RegisterController@register");
Route::post('user/reset', "Api\PasswordResetController@resetUser");
Route::post('admin/reset', "Api\Admin\DashboardController@resetAdmin");
