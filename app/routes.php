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
	return View::make('index');
});

/*
|--------------------------------------------------------------------------
| MODE ROUTES
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'mode'), function() {

    Route::get('management', function()
    {
        if ( Auth::user()->ability(['manager', 'administrator'],[]) ){
            Session::put('management', true);
        }
        return Redirect::to('/');
    });

    Route::get('normal', function()
    {
        Session::forget('management');
        return Redirect::to('/');
    });

});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::post('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout');
Route::get('info', 'AuthController@info');

/*
|--------------------------------------------------------------------------
| API ROUTES
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'api'), function() {
    $rest_only = array('index', 'show', 'store', 'update','destroy');
    Route::resource('users', 'UserController', array('only' => $rest_only));
    Route::resource('boards', 'BoardController', array('only' => $rest_only));
    Route::resource('records', 'ApplyRecordController', array('only' => $rest_only));

    Route::get('views/{name?}', 'ViewController@getView');
    Route::get('maps/{name?}', 'ViewController@getMap');
});
