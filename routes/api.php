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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('file/delete', 'Backend\\CommonController@fileDelete');

Route::group(['namespace' => 'API'], function () {
	Route::group(['middleware' => 'client'], function () {
		Route::get('testmodules', 'TestmoduleController@index')->name('testmodule.index');
		Route::post('testmodule/store', 'TestmoduleController@store')->name('testmodule.store');
		Route::post('testmodule/update', 'TestmoduleController@store')->name('testmodule.update');
		Route::get('testmodule/edit/{id}', 'TestmoduleController@edit')->name('testmodule.edit');
		Route::get('testmodule/destroy/{id}', 'TestmoduleController@destroy')->name('testmodule.destroy');
	});
});
// [RouteArray]
