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

Route::get('/test', 'TestControllers@index')->name('test');//->middleware();

Route::get('/registration', [
	'as' => 'UserRegistrationControllerFormRender',
	'uses' => 'UserRegistrationController@Form',
]);


Route::post('/registration', [
	'as' => 'UserRegistrationControllerRegistration',
	'uses' => 'UserRegistrationController@Registration',
]);
