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

Route::get('/home', 'HomeController@index')->name('home');


/**
 * Admin Guard
 */
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
	// Home
    Route::get('/home', 'HomeController@index')->name('home');    
});
/**
 * Juri Guard
 */
Route::namespace('Juri')->prefix('juri')->name('juri.')->middleware(['auth:juri'])->group(function () {
	// Home
    Route::get('/home', 'HomeController@index')->name('home');    
});