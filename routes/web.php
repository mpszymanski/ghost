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

Route::group(['middleware'=> 'auth'], function() {
	Route::post('/{id}/join', 'EventsController@join')->name('events.join');
	Route::post('/{id}/leave', 'EventsController@leave')->name('events.leave');

	Route::get('/events', 'EventsController@index')->name('events.index');
	Route::get('/events/create', 'EventsController@create')->name('events.create');
	Route::post('/events', 'EventsController@store')->name('events.store');
	Route::get('/events/{id}/edit', 'EventsController@edit')->name('events.edit');
	Route::put('/events/{id}', 'EventsController@update')->name('events.update');
	Route::delete('/events/{id}', 'EventsController@destroy')->name('events.destroy');
});

Route::get('/{id}/{slug}', 'EventsController@show')->name('events.show');

