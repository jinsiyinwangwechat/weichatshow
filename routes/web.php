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

Route::any('/wechat', 'WechatController@serve');
Route::any('/factory/detail', 'FactoryController@getFactoryDetail');
Route::get('/factory/listPage', 'FactoryController@listPage');
Route::get('/factory/detailPage', 'FactoryController@detailPage');
Route::get('/factory/list','FactoryController@getFactoryList');
Route::get('/factory/search', 'FactoryController@searchFactory');
Route::get('/factory/my', 'FactoryController@collectListPage');
Route::any('/do/collection', 'FactoryController@doCollection');
Route::post('/cancel/collection', 'FactoryController@doCollection');

Route::group([ 'middleware' => ['wechat.oauth']], function () {

    Route::any('/test', 'TestController@test');
});
