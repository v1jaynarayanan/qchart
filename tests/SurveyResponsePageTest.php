<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use App\Http\Controllers\Auth\SurveyAuthController;
use App\EmailLogin;
use App\SurveyQuestions;
use App\SurveyAnswers;
use Log;

class SurveyResponsePageTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testShouldShowSurveyResponsePageForActiveUser()
    {
        $emailLogin = EmailLogin::createForEmail('newuser5@user.com');
        $user = factory(App\User::class)->create([
                    'name' => 'newuser5',
                    'email' => 'newuser5@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);
        
        $survey = factory(App\Survey::class)->create([
                    'user_id' => $user->id,
                    'title' => 'Test Survey',
                    'slug' => 'Test Survey',
                    'description' => 'Test Survey',
                    'status' => 1]);

        SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q1',
        ]);

        $this->actingAs($user);

        $response = $this->action('GET', 'Auth\SurveyAuthController@activeUserCompleteSurvey', ['surveyId' => $survey->id, 'token' => $emailLogin->token]);

        $this->see('Please fill out your answers for the survey');
    }

    public function testShouldCompleteSurveyResponseForActiveUser()
    {
        $emailLogin = EmailLogin::createForEmail('newuser5@user.com');
        $user = factory(App\User::class)->create([
                    'name' => 'newuser5',
                    'email' => 'newuser5@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);
        
        $survey = factory(App\Survey::class)->create([
                    'user_id' => $user->id,
                    'title' => 'Test Survey',
                    'slug' => 'Test Survey',
                    'description' => 'Test Survey',
                    'status' => 1]);

        SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q1',
        ]);

        $response = $this->action('GET', 'Auth\SurveyAuthController@activeUserCompleteSurvey', ['surveyId' => $survey->id, 'token' => $emailLogin->token]);

        $this->see('Please fill out your answers for the survey');
        
        $ans = array('answer'=>'1');

        $this->actingAs($user);
        $response = $this->action('POST', 'SurveyController@activeUserSurveyResponse', ['question1' => 1, 'answer' => $ans]);
        $this->see('Thank you for submitting the response. Your response has been successfully saved.');

    }

    public function testShouldShowSurveyResponsePageForNewUser()
    {
        $user = factory(App\User::class)->create([
                    'name' => 'newuser5',
                    'email' => 'newuser5@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);
        
        $survey = factory(App\Survey::class)->create([
                    'user_id' => $user->id,
                    'title' => 'Test Survey',
                    'slug' => 'Test Survey',
                    'description' => 'Test Survey',
                    'status' => 1]);

        SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q1',
        ]);

        $response = $this->action('GET', 'Auth\SurveyAuthController@newUserCompleteSurvey', ['surveyId' => $survey->id, 'email' => 'newuser5@user.com']);

        $this->see('Please fill out your answers for the survey');
    }

    public function testShouldCompleteSurveyResponseForNewUserWithAnonymousName()
    {
        $user = factory(App\User::class)->create([
                    'name' => 'newuser5',
                    'email' => 'newuser5@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);
        
        $survey = factory(App\Survey::class)->create([
                    'user_id' => $user->id,
                    'title' => 'Test Survey',
                    'slug' => 'Test Survey',
                    'description' => 'Test Survey',
                    'status' => 1]);

        SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q1',
        ]);

        $response = $this->action('GET', 'Auth\SurveyAuthController@newUserCompleteSurvey', ['surveyId' => $survey->id, 'email' => 'newuser5@user.com']);

        $this->see('Please fill out your answers for the survey');
        
        $ans = array('answer'=>'1');

        $response = $this->action('POST', 'SurveyController@newUserSurveyResponse', ['question1' => 1, 'answer' => $ans, 'email' => 'newuser5@user.com']);
        $this->see('Thank you for submitting the response. Your response has been successfully saved.');
    }

    public function testShouldCompleteSurveyResponseForNewUserWithName()
    {
        $user = factory(App\User::class)->create([
                    'name' => 'newuser5',
                    'email' => 'newuser5@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);
        
        $survey = factory(App\Survey::class)->create([
                    'user_id' => $user->id,
                    'title' => 'Test Survey',
                    'slug' => 'Test Survey',
                    'description' => 'Test Survey',
                    'status' => 1]);

        SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q1',
        ]);

        $response = $this->action('GET', 'Auth\SurveyAuthController@newUserCompleteSurvey', ['surveyId' => $survey->id, 'email' => 'newuser5@user.com']);

        $this->see('Please fill out your answers for the survey');
        
        $ans = array('answer'=>'1');

        $response = $this->action('POST', 'SurveyController@newUserSurveyResponse', ['question1' => 1, 'answer' => $ans, 'name' => 'TEST', 'email' => 'newuser5@user.com']);
        $this->see('Thank you for submitting the response. Your response has been successfully saved.');

    }
}
