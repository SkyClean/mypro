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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/activities', 'ActivityController@activities')->name('activities');

Route::get('/servers/new', ['as' => 'admin.server.new', 'uses' => 'ServerController@newServer']);
Route::get('/servers', ['as' => 'admin.servers', 'uses' => 'ServerController@servers']);
Route::get('/servers/{id}', ['as' => 'admin.editServer', 'uses' => 'ServerController@editServer']);
Route::delete('/servers/{id}', ['uses' => 'ServerController@destroy']);
Route::post('/server', ['as' => 'admin.postservers', 'uses' => 'ServerController@postEdit']);

Route::get('/servers/connect/{id}', ['as' => 'admin.connection', 'uses' => 'ConnectionController@connection']);
Route::post('/servers/cmd/{id}', ['as' => 'admin.cmd', 'uses' => 'ConnectionController@cmd']);
Route::post('/server/makeconnect/{id}', ['as' => 'admin.makeconnect', 'uses' => 'ConnectionController@makeconnect']);
Route::post('/server/getcmd/{id}', ['as' => 'admin.getcmd', 'uses' => 'ConnectionController@getcmd']);
Route::post('/server/disconnect/{id}', ['as' => 'admin.disconnect', 'uses' => 'ConnectionController@disconnect']);
Route::post('/server/sessionlog/update/{id}', ['as' => 'admin.disconnect', 'uses' => 'ConnectionController@sessionlogUpdate']);
