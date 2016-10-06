<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('app');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

/*
Route::group(['prefix' => 'api'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
});
*/

#'middleware' => 'web', 
Route::group(['middleware' => 'web'], function () {
    Route::get('main', 'MainController@main');
    Route::get('ppo', 'MainController@ppo');
    Route::get('smr', 'MainController@smr');
    Route::post('create_smr', 'MainController@create_smr');
    Route::post('update_smr', 'MainController@update_smr');
    Route::get('search', 'MainController@search');

    #Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    #Route::post('authenticate', 'AuthenticateController@authenticate');

});

// Templates
Route::group(['prefix' => '/templates/'], function(){
    Route::get('{template}', [function($template)
    {
        $template = str_replace(".html","",$template);
        View::addExtension('html','php');
        return View::make('templates.'.$template);
    }]);
});
