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
Route::get('/test', 'Web\test\test@index')->name('test');//->middleware();

/*
Route::domain('partner.service-voice.com')->group(function () {


    Route::get('/docs', [
        'as' => 'docs',
        'uses' => function () {
            return Redirect::to('/docs');
        }
    ]);

    Route::get('/dashboard', [
        'name' => 'Центр упарвления',
        'as' => 'dashboard',
        'uses' => 'Web\dashboard\DashboardController@index'
    ]);

    Route::get('/teamspeak3/dns', [
        'name' => 'Центр упарвления',
        'as' => 'teamspeak3-dns',
        'uses' => 'Web\TeamSpeak\DnsController@list'
    ]);

    Route::get('/monitoring', [
        'name' => 'Центр упарвления',
        'as' => 'monitoring',
        'uses' => 'web\dashboard\DashboardController@index'
    ]);

    Route::get('/teamspeak3-server', [
        'name' => 'Центр упарвления',
        'as' => 'teamspeak3-server',
        'uses' => 'web\dashboard\DashboardController@index'
    ]);

    Route::get('/api-app', [
        'name' => 'api-app',
        'as' => 'api-app',
        'uses' => 'web\api\APIWEBController@app'
    ]);

    Route::get('/api-log', [
        'name' => 'api-log',
        'as' => 'api-log',
        'uses' => 'web\api\APIWEBController@log'
    ]);

    Route::get('/api-stat', [
        'name' => 'api-stat',
        'as' => 'api-stat',
        'uses' => 'web\api\APIWEBController@stat'
    ]);



    Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);

    Route::post('/logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
});*/
