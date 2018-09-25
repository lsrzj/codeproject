<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web Routes for your application. These
| Routes are loaded by the RouteServiceProvider within a group which
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
    Route::get('{id}/note', 'ProjectNoteController@index');
    Route::post('{id}/note', 'ProjectNoteController@store');
    Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
    Route::put('update/note/{id}', 'ProjectNoteController@update');
    Route::delete('delete/note/{id}', 'ProjectNoteController@destroy');

    Route::get('{id}/task', 'ProjectTaskController@index');
    Route::post('{id}/task', 'ProjectTaskController@store');
    Route::get('{id}/task/{noteId}', 'ProjectTaskController@show');
    Route::put('update/task/{id}', 'ProjectTaskController@update');
    Route::delete('delete/task/{id}', 'ProjectTaskController@destroy');

    Route::get('{id}/members', 'ProjectController@listMembers');
    Route::post('{id}/add/members/{memberId}', 'ProjectController@addMember');
    Route::delete('{id}/remove/members/{memberId}', 'ProjectController@removeMember');
    

    Route::get('', 'ProjectController@index');
    Route::post('', 'ProjectController@store');
    Route::get('{id}', 'ProjectController@show');
    Route::delete('{id}', 'ProjectController@destroy');
    Route::put('{id}', 'ProjectController@update');
});


