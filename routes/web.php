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
    //NOTE
    Route::get('{id}/note', 'ProjectNoteController@getNotes');
    Route::post('add/note/', 'ProjectNoteController@addNote');
    Route::get('{id}/note/{noteId}', 'ProjectNoteController@showNote');
    Route::put('update/note', 'ProjectNoteController@updateNote');
    Route::delete('delete/note/', 'ProjectNoteController@deleteNote');
    //TASK
    Route::get('{id}/task', 'ProjectTaskController@getTasks');
    Route::post('add/task', 'ProjectTaskController@addTask');
    Route::get('{id}/task/{noteId}', 'ProjectTaskController@showTask');
    Route::put('update/task', 'ProjectTaskController@updateTask');
    Route::delete('delete/task', 'ProjectTaskController@deleteTask');
    //MEMBERS
    Route::get('{id}/members', 'ProjectController@listMembers');
    Route::post('add/member', 'ProjectController@addMember');
    Route::delete('remove/member', 'ProjectController@removeMember');
    //FILES
    Route::post('add/file', 'ProjectController@addFile');
  });
});