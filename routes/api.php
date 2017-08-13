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

Route::any('/detail/factory', 'FactoryController@getFactoryDetail');
Route::get('/factory/list','FactoryController@getFactoryList');
Route::get('/factory/search', 'FactoryController@searchFactory');
Route::any('/do/collection', 'FactoryController@doCollection');
Route::post('/cancel/collection', 'FactoryController@doCollection');
