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

Auth::routes();

Route::get('/ip', function() {
	return request()->getClientIp();
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/map/events/{position}', 'HomeController@mapEvents')->name('map.events');

Route::get('/{id}/{slug}', 'EventsController@show')->name('events.show');

Route::group(['middleware'=> 'auth'], function() {
	Route::post('/{id}/join', 'EventsController@join')->name('events.join');
	Route::get('/events', 'EventsController@index')->name('events.index');
});

