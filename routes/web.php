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

Route::group(['middleware' => 'auth:api'], function () {
  Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);


  Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
  Route::group(['prefix' => 'project'], function () {
    Route::get('{id}/note', 'ProjectController@getNotes');
    Route::post('add/note/', 'ProjectController@addNote');
    Route::get('{id}/note/{noteId}', 'ProjectController@showNote');
    Route::put('update/note', 'ProjectController@updateNote');
    Route::delete('delete/note/', 'ProjectController@deleteNote');
    Route::get('{id}/task', 'ProjectController@getTasks');
    Route::post('add/task', 'ProjectController@addTask');
    Route::get('{id}/task/{noteId}', 'ProjectController@showTask');
    Route::put('update/task', 'ProjectController@updateTask');
    Route::delete('delete/task', 'ProjectController@deleteTask');
    Route::get('{id}/members', 'ProjectController@listMembers');
    Route::post('add/member', 'ProjectController@addMember');
    Route::delete('remove/member', 'ProjectController@removeMember');
  });
});