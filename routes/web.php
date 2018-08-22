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
    
Route::group(['prefix' => 'client'], function () {
    Route::get('', 'ClientController@index');
    Route::post('', 'ClientController@store');
    Route::get('{id}', 'ClientController@show');
    Route::delete('{id}', 'ClientController@destroy');
    Route::put('{id}', 'ClientController@update');
});


Route::group(['prefix' => 'project'], function () {
    route::get('{id}/note', 'ProjectNoteController@index');
    route::post('{id}/note', 'ProjectNoteController@store');
    route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
    route::put('update/note/{id}', 'ProjectNoteController@update');
    route::delete('delete/note/{id}', 'ProjectNoteController@destroy');

    Route::get('', 'ProjectController@index');
    Route::post('', 'ProjectController@store');
    Route::get('{id}', 'ProjectController@show');
    Route::delete('{id}', 'ProjectController@destroy');
    Route::put('{id}', 'ProjectController@update');
});


