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



/*Admin home route*/
Route::get('admin/login', ['as' => 'getLogin', 'uses' => 'Admin\AuthController@getLogin']);
Route::post('admin/login', ['as' => 'postLogin', 'uses' => 'Admin\AuthController@postLogin']);
Route::post('admin/logout', ['as' => 'getLogout', 'uses' => 'Admin\AuthController@getLogout']);

Route::group(['middleware' => 'CheckAdmin', 'prefix' => 'admin'], function() {
    Route::get('/', ['as' => 'homeAdmin', 'uses' => 'Admin\AdminController@index']);
    Route::get('/orders', ['as' => 'orderAdmin', 'uses' => 'Admin\AdminController@getOrders']);
});

Route::get('send-message', 'RedisController@index');
Route::post('send-message', 'RedisController@postSendMessage');

/*Store route*/
Auth::routes();
Route::group(['middleware' => 'CheckStore', 'prefix' => 'store'], function(){
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('/orders', 'OrderController');
});


