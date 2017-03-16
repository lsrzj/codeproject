<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return view('welcome');
});

//The auth middleware is being used to make sure that only authenticated users can access admin pages
Route::group(['prefix' => 'client'], function() {
    Route::get('', 'ClientController@index');
    Route::post('', 'ClientController@store');
    Route::get('{id}', 'ClientController@show');
    Route::put('{id}', 'ClientController@update');
    Route::delete('{id}', 'ClientController@destroy');
});

Route::group(['prefix' => 'project'], function() {
    Route::get('', 'ProjectController@index');
    Route::post('', 'ProjectController@store');
    Route::get('{id}', 'ProjectController@show');
    Route::put('{id}', 'ProjectController@update');
    Route::delete('{id}', 'ProjectController@destroy'); 
    Route::get('findByOwner/{id}', 'ProjectController@ProjectsOwnedBy');
});
