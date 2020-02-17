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
	if(Auth::check()){
		return redirect('home');
	}else{
		return view('welcome');
	}
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('home', 'HomeController@index')->name('home');
	Route::post('home', 'HomeController@index');
	// Route::get('data', 'DataController@index')->name('data.index');;
	// Route::get('data/create', 'DataController@create')->name('data.create');
	// Route::get('data', ['as' => 'data.edit', 'uses' => 'DataController@edit']);
	
	Route::resource('user', 'UserController', ['except' => ['show']]);

	// Admin routes
	Route::group(['prefix'=>'admin'], function() {

		Route::group(['prefix'=>'data'], function() {

			// Special data routes
			Route::get('search', 'DatumController@search')->name('search');
			Route::post('calculate', 'DatumController@calculateApriori')->name('calculate_apriori');
		});

		// Data resources
		Route::resource('data', 'DatumController');

	});

	// Profile routes
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

