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
	Route::post('/events/{id}/join', 'EventsController@join')->name('events.join');
	Route::post('/events/{id}/leave', 'EventsController@leave')->name('events.leave');
	Route::post('/events/invite', 'EventsController@invite')->name('events.invite');

	Route::get('/events', 'EventsController@index')->name('events.index');
	Route::get('/events/create', 'EventsController@create')->name('events.create');
	Route::post('/events', 'EventsController@store')->name('events.store');
	Route::get('/events/{id}/edit', 'EventsController@edit')->name('events.edit');
	Route::put('/events/{id}', 'EventsController@update')->name('events.update');
	Route::delete('/events/{id}', 'EventsController@destroy')->name('events.destroy');

	Route::get('/mailable', function () {
	    $event = App\Event::find(1);
	    $user = Auth::user();
	    $message = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum saepe, voluptas totam placeat aut velit numquam perspiciatis commodi reiciendis minima, architecto nesciunt. Laborum tenetur, omnis necessitatibus nisi ipsam ipsum sapiente.';

	    return new App\Mail\Invitation($user, $event, $message);
	});

});

Route::get('users/autoload', function() {
	$query = request()->get('q');
	return App\User::where('nick', 'like', "%$query%")->orWhere('email', 'like', "%$query%")
		->take(20)
		->get()
		->map(function($user) {
			return "{$user->nick}<{$user->email}>";
		});
})->name('users.autoload');

Route::get('/{id}/{slug}', 'EventsController@show')->name('events.show');