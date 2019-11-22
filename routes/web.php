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

Route::get('/', function(){
	return redirect()->route('login');
});

Route::get('/home', 'HomeController@index')->name('home');


/**
 * Admin Guard
 */
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
	// Home
    Route::get('/home', 'HomeController@index')->name('home');

    // Competition
	Route::resource('competition', 'CompetitionController', ['except' => [
		'destroy',
	]]);
	Route::prefix('competition')->name('competition.')->group(function () {
		Route::post('list', 'CompetitionController@list')->name('list');
		Route::get('destroy/{competition}', 'CompetitionController@destroy')->name('destroy');
	});

	// Contest
	Route::resource('contest', 'ContestController', ['except' => [
		'destroy',
	]]);
	Route::prefix('contest')->name('contest.')->group(function () {
		Route::post('list', 'ContestController@list')->name('list');
		Route::delete('destroy', 'ContestController@destroy')->name('destroy');
	});

	// School
	Route::resource('school', 'SchoolController', ['except' => [
		'destroy',
	]]);
	Route::prefix('school')->name('school.')->group(function () {
		Route::post('list', 'SchoolController@list')->name('list');
		Route::delete('destroy', 'SchoolController@destroy')->name('destroy');
	});

	// Administrator
	Route::resource('administrator', 'AdministratorController', ['except' => [
		'destroy',
	]]);
	Route::prefix('administrator')->name('administrator.')->group(function () {
		Route::post('list', 'AdministratorController@list')->name('list');
		Route::delete('destroy', 'AdministratorController@destroy')->name('destroy');
	});

	// Juri
	Route::resource('juri', 'JudgeController', ['except' => [
		'destroy',
	]]);
	Route::prefix('juri')->name('juri.')->group(function () {
		Route::post('list', 'JudgeController@list')->name('list');
		Route::delete('destroy', 'JudgeController@destroy')->name('destroy');
	});

	// User
	Route::resource('user', 'UserController', ['except' => [
		'destroy',
	]]);
	Route::prefix('user')->name('user.')->group(function () {
		Route::post('list', 'UserController@list')->name('list');
		Route::delete('destroy', 'UserController@destroy')->name('destroy');
	});

});
/**
 * Juri Guard
 */
Route::namespace('Juri')->prefix('juri')->name('juri.')->middleware(['auth:juri'])->group(function () {
	// Home
    Route::get('/home', 'HomeController@index')->name('home');    
});