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

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/details/{surveyId}', [
	'as' => 'survey.details',  
	'uses' => 'HomeController@surveyDetails'
]);

Route::get('auth/email-authenticate/{token}', [
    'as' => 'auth.email-authenticate',
    'uses' => 'Auth\AuthController@authenticateEmail'
]);

Route::get('/drawGraph/{survey}', [
	'as' => 'survey.graph',  
	'uses' => 'SurveyController@drawGraph'
]);

Route::get('/graph', 'SurveyController@draw');