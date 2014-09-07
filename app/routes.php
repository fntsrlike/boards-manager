<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| HOME ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function()
{
	return View::make('hello');
});

/*
|--------------------------------------------------------------------------
| API ROUTES
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'api'), function() {
    $rest_only = array('index', 'show', 'store', 'update','destroy');
    Route::resource('user', 'UserController', array('only' => $rest_only));
    Route::resource('board', 'BoardController', array('only' => $rest_only));
    Route::resource('apply_record', 'ApplyRecordController', array('only' => $rest_only));
});
