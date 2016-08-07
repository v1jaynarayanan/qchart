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

Route::get('auth/email-authenticate/{token}', [
    'as' => 'auth.email-authenticate',
    'uses' => 'Auth\AuthController@authenticateEmail'
]);

Route::get('/home', 'HomeController@index');

Route::get('/details/{surveyId}', [
	'as' => 'survey.details',  
	'uses' => 'HomeController@surveyDetails'
]);

Route::get('/drawGraph/{survey}', [
	'as' => 'survey.graph',  
	'uses' => 'SurveyController@drawGraph'
]);

Route::get('/graph', 'SurveyController@draw');

Route::delete('/deleteSurvey', [
  	'as'=> 'survey.delete',
  	'uses'=> 'HomeController@deleteSurvey'
]);

Route::get('/sendSurvey/{survey}', [
	'as' => 'survey.send',  
	'uses' => 'HomeController@sendSurvey'
]);

Route::get('/showNewSurveyPage', 'HomeController@showNewSurveyPage');

Route::post('/survey/sendEmail', [
	'as' => 'survey.sendemail',  
	'uses' => 'SurveyController@sendSurveyEmail'
]);

Route::post('/createNewSurvey', [
  'as' => 'survey.create',  
  'uses' => 'SurveyController@createNewSurvey'
]);

Route::post('/closeSurvey/{survey}', [
  'as' => 'survey.close',  
  'uses' => 'HomeController@closeSurvey'
]);

Route::group(['middlewareGroups' => 'web'], function () {

  Route::get('surveyComplete/{surveyId}/token/{token?}', [
    'as' => 'activeuser.survey.complete',
    'uses' => 'Auth\SurveyAuthController@activeUserCompleteSurvey'
  ]);

  Route::get('surveyComplete/{surveyId}/email/{email?}', [
    'as' => 'newuser.survey.complete',
    'uses' => 'Auth\SurveyAuthController@newUserCompleteSurvey'
  ]);

  Route::post('/submit/activeUserSurveyResponse', [
      'as' => 'activeuser.submit.survey.response',  
      'uses' => 'SurveyController@activeUserSurveyResponse'
    ]);   

  Route::post('/submit/newUserSurveyResponse', [
      'as' => 'newuser.submit.survey.response',  
      'uses' => 'SurveyController@newUserSurveyResponse'
    ]);  

});
