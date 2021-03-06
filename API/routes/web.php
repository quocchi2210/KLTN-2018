<?php

/*Home route*/
Route::get('/', function () {
	return view('welcome');
});

/*Download app route*/
Route::get('/download', function () {
	return view('download');
});

Route::post('/tracking', ['as' => 'tracking', 'uses' => 'OrderController@tracking']);
Route::get('/user/verify/{user_id}/{token}', 'Auth\RegisterController@verifyUser')->name('verify.user');
Route::get('/user/password/reset/{user_id}/{token}','Auth\ResetPasswordController@showResetForm')->name('reset.user');
Route::post('/user/password/reset/{user_id}/{token}','Auth\ResetPasswordController@reset');
Route::get('/deliver/confirm/{user_id}/{token}','Admin\DeliverController@getconfirmDeliver')->name('confirm.deliver');
Route::post('/deliver/confirm/{user_id}/{token}','Admin\DeliverController@confirmDeliver');




/*Admin home route*/
Route::get('admin/login', ['as' => 'getLogin', 'uses' => 'Admin\AuthController@getLogin']);
Route::post('admin/login', ['as' => 'postLogin', 'uses' => 'Admin\AuthController@postLogin']);
Route::post('admin/logout', ['as' => 'getLogout', 'uses' => 'Admin\AuthController@getLogout']);

Route::group(['middleware' => 'CheckAdmin', 'prefix' => 'admin' , 'as' =>'admin.'], function() {
    Route::get('/', ['as' => 'homeAdmin', 'uses' => 'Admin\AdminController@index']);
    Route::resource('/orders','Admin\OrderController');
    Route::resource('/stores','Admin\StoreController');
    Route::resource('/delivers','Admin\DeliverController');

});

Route::get('send-message', 'RedisController@index');
Route::post('send-message', 'RedisController@postSendMessage');
Route::get("message", function () {
	return view("message");
});

/*Store route*/
Auth::routes();
Route::group(['middleware' => 'CheckStore', 'prefix' => 'store'], function(){
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('/orders', 'OrderController');
    Route::post('/order/getPreMoney','OrderController@getPreMoney')->name('store.order.preMoney');
    Route::get('/profile/{store}/edit','HomeController@editProfile')->name('profile.edit');
    Route::put('/profile/{store}','HomeController@updateProfile')->name('profile.update');

});
