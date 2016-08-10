<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use App\Http\Controllers\Auth\SurveyAuthController;
use App\User;
use App\EmailLogin;
use App\SurveyQuestions;
use App\SurveyAnswers;

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

        $s1 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q1',
        ]);

        $s2 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q2',
        ]);

        $s3 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q3',
        ]);
        
        $s4 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q4',
        ]);

        $s5 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q5',
        ]);

        $s6 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q6',
        ]);

        $s7 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q7',
        ]);
        
        $s8 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q8',
        ]);

        $response = $this->action('GET', 'Auth\SurveyAuthController@activeUserCompleteSurvey', ['surveyId' => $survey->id, 'token' => $emailLogin->token]);

        $this->see('Please fill out your answers for the survey');
        
        $ans = array('answer1'=>'1');
        $ans = array_add($ans, 'answer2','10');
        $ans = array_add($ans, 'answer3','9');
        $ans = array_add($ans, 'answer4','4');
        $ans = array_add($ans, 'answer5','2');
        $ans = array_add($ans, 'answer6','7');
        $ans = array_add($ans, 'answer7','10');
        $ans = array_add($ans, 'answer8','1');

        $this->actingAs($user);
        $response = $this->action('POST', 'SurveyController@activeUserSurveyResponse', ['question1' => 1, 'question2' => 2, 'question3' => 3, 'question4' => 4, 'question5' => 5, 'question6' => 6, 'question7' => 7, 'question8' => 8, 'answer' => $ans]);
        $this->see('Thank you for submitting the response. Your response has been successfully saved.');

        $sa1 = SurveyAnswers::where('survey_quest_id','=',$s1->id)
                     ->where('user_id','=',$user->id)->first();
        $this->assertEquals(1,$sa1->answer);      
        
        $sa2 = SurveyAnswers::where('survey_quest_id','=',$s2->id)
                     ->where('user_id','=',$user->id)->first();
        $this->assertEquals(10,$sa2->answer);

        $sa3 = SurveyAnswers::where('survey_quest_id','=',$s3->id)
                     ->where('user_id','=',$user->id)->first();
        $this->assertEquals(9,$sa3->answer);

        $sa4 = SurveyAnswers::where('survey_quest_id','=',$s4->id)
                     ->where('user_id','=',$user->id)->first();
        $this->assertEquals(4,$sa4->answer);

        $sa5 = SurveyAnswers::where('survey_quest_id','=',$s5->id)
                     ->where('user_id','=',$user->id)->first();
        $this->assertEquals(2,$sa5->answer);      
        
        $sa6 = SurveyAnswers::where('survey_quest_id','=',$s6->id)
                     ->where('user_id','=',$user->id)->first();
        $this->assertEquals(7,$sa6->answer);

        $sa7 = SurveyAnswers::where('survey_quest_id','=',$s7->id)
                     ->where('user_id','=',$user->id)->first();
        $this->assertEquals(10,$sa7->answer);

        $sa8 = SurveyAnswers::where('survey_quest_id','=',$s8->id)
                     ->where('user_id','=',$user->id)->first();
        $this->assertEquals(1,$sa8->answer);
    }

    public function testShouldReturnAlreadyAnsweredForActiveUser()
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

        $s1 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q1',
        ]);


        $response = $this->action('GET', 'Auth\SurveyAuthController@activeUserCompleteSurvey', ['surveyId' => $survey->id, 'token' => $emailLogin->token]);

        $this->see('Please fill out your answers for the survey');

        $ans = array('answer1'=>'5');

        $this->actingAs($user);
        $response = $this->action('POST', 'SurveyController@activeUserSurveyResponse', ['question1' => 1, 'answer' => $ans]);
        $this->see('Thank you for submitting the response. Your response has been successfully saved.');

        $sa1 = SurveyAnswers::where('survey_quest_id','=',$s1->id)
                     ->where('user_id','=',$user->id)->first();
        $this->assertEquals(5,$sa1->answer);      
        
        $response = $this->action('POST', 'SurveyController@activeUserSurveyResponse', ['question1' => 1, 'answer' => $ans]);

        LOG::info($response);
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('http://localhost/surveyComplete/1/token/'.$emailLogin->token);
        $this->visit('http://localhost/surveyComplete/1/token/'.$emailLogin->token);
        $this->see('You have already submitted your response');
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

        $response = $this->action('GET', 'Auth\SurveyAuthController@newUserCompleteSurvey', ['surveyId' => $survey->id, 'email' => 'newanonymoususer@user.com']);

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

        $response = $this->action('GET', 'Auth\SurveyAuthController@newUserCompleteSurvey', ['surveyId' => $survey->id, 'email' => 'newanonymoususer@user.com']);

        $this->see('Please fill out your answers for the survey');
        
        $ans = array('answer'=>'1');

        $response = $this->action('POST', 'SurveyController@newUserSurveyResponse', ['question1' => 1, 'answer' => $ans, 'email' => 'newanonymoususer@user.com']);
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

        $s1 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q1',
        ]);

        $s2 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q2',
        ]);

        $s3 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q3',
        ]);

        $s4 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q4',
        ]);

        $s5 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q5',
        ]);

        $s6 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q6',
        ]);

        $s7 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q7',
        ]);

        $s8 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q8',
        ]);

        $response = $this->action('GET', 'Auth\SurveyAuthController@newUserCompleteSurvey', ['surveyId' => $survey->id, 'email' => 'newuserwithname@user.com']);

        $this->see('Please fill out your answers for the survey');
        
        $ans = array('answer1'=>'1');
        $ans = array_add($ans, 'answer2','10');
        $ans = array_add($ans, 'answer3','9');
        $ans = array_add($ans, 'answer4','4');
        $ans = array_add($ans, 'answer5','2');
        $ans = array_add($ans, 'answer6','7');
        $ans = array_add($ans, 'answer7','10');
        $ans = array_add($ans, 'answer8','1');

        $response = $this->action('POST', 'SurveyController@newUserSurveyResponse', ['question1' => 1, 'question2' => 2, 'question3' => 3, 'question4' => 4, 'question5' => 5, 'question6' => 6, 'question7' => 7, 'question8' => 8, 'answer' => $ans, 'name' => 'TestUser', 'email' => 'newuserwithname@user.com']);
        $this->see('Thank you for submitting the response. Your response has been successfully saved.');

        $respUser = User::where('email','=', 'newuserwithname@user.com')->first();
        $this->assertEquals('TestUser', $respUser->name);

        $sa1 = SurveyAnswers::where('survey_quest_id','=',$s1->id)
                     ->where('user_id','=',$respUser->id)->first();
        $this->assertEquals(1,$sa1->answer);      
        
        $sa2 = SurveyAnswers::where('survey_quest_id','=',$s2->id)
                     ->where('user_id','=',$respUser->id)->first();
        $this->assertEquals(10,$sa2->answer);

        $sa3 = SurveyAnswers::where('survey_quest_id','=',$s3->id)
                     ->where('user_id','=',$respUser->id)->first();
        $this->assertEquals(9,$sa3->answer);

        $sa4 = SurveyAnswers::where('survey_quest_id','=',$s4->id)
                     ->where('user_id','=',$respUser->id)->first();
        $this->assertEquals(4,$sa4->answer);

        $sa5 = SurveyAnswers::where('survey_quest_id','=',$s5->id)
                     ->where('user_id','=',$respUser->id)->first();
        $this->assertEquals(2,$sa5->answer);      
        
        $sa6 = SurveyAnswers::where('survey_quest_id','=',$s6->id)
                     ->where('user_id','=',$respUser->id)->first();
        $this->assertEquals(7,$sa6->answer);

        $sa7 = SurveyAnswers::where('survey_quest_id','=',$s7->id)
                     ->where('user_id','=',$respUser->id)->first();
        $this->assertEquals(10,$sa7->answer);

        $sa8 = SurveyAnswers::where('survey_quest_id','=',$s8->id)
                     ->where('user_id','=',$respUser->id)->first();
        $this->assertEquals(1,$sa8->answer);

    }

    public function testShouldReturnAlreadyAnsweredForNewAnonymousUser()
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

        $s1 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q1',
        ]);


        $response = $this->action('GET', 'Auth\SurveyAuthController@newUserCompleteSurvey', ['surveyId' => $survey->id, 'email' => 'newanonymoususer@user.com']);

        $this->see('Please fill out your answers for the survey');

        $ans = array('answer1'=>'5');

        $response = $this->action('POST', 'SurveyController@newUserSurveyResponse', ['question1' => 1, 'answer' => $ans, 'email' => 'newanonymoususer@user.com']);
        $this->see('Thank you for submitting the response. Your response has been successfully saved.');

        $respUser = User::where('email','=', 'newanonymoususer@user.com')->first();
        $this->assertEquals('Anonymous', $respUser->name);

        $sa1 = SurveyAnswers::where('survey_quest_id','=',$s1->id)
                            ->where('user_id','=',$respUser->id)->first();
        $this->assertEquals(5,$sa1->answer);      
        
        $response = $this->action('POST', 'SurveyController@newUserSurveyResponse', ['question1' => 1, 'answer' => $ans, 'email' => 'newanonymoususer@user.com']);
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('http://localhost/surveyComplete/1/email/'.$respUser->email);
        $this->visit('http://localhost/surveyComplete/1/email/'.$respUser->email);
        $this->see('You have already submitted your response'); 
    }

    public function testShouldReturnAlreadyAnsweredForExistingAnonymousUser()
    {
        $anonUser = factory(App\User::class)->create([
                    'name' => 'Anonymous',
                    'email' => 'existinganonymoususer@user.com',
                    'role_id' => 0,
                    'confirmed' => 0,
                    'admin' => 0]);

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

        $s1 = SurveyQuestions::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q1',
        ]);


        $response = $this->action('GET', 'Auth\SurveyAuthController@newUserCompleteSurvey', ['surveyId' => $survey->id, 'email' => 'existinganonymoususer@user.com']);

        $this->see('Please fill out your answers for the survey');

        $ans = array('answer1'=>'5');

        $response = $this->action('POST', 'SurveyController@newUserSurveyResponse', ['question1' => 1, 'answer' => $ans, 'email' => 'existinganonymoususer@user.com']);
        $this->see('Thank you for submitting the response. Your response has been successfully saved.');

        $respUser = User::where('email','=', 'existinganonymoususer@user.com')->first();
        $this->assertEquals($anonUser->id, $respUser->id);
        $this->assertEquals('Anonymous', $respUser->name);

        $sa1 = SurveyAnswers::where('survey_quest_id','=',$s1->id)
                            ->where('user_id','=',$respUser->id)->first();
        $this->assertEquals(5,$sa1->answer);      
        
        $response = $this->action('POST', 'SurveyController@newUserSurveyResponse', ['question1' => 1, 'answer' => $ans, 'email' => 'existinganonymoususer@user.com']);
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('http://localhost/surveyComplete/1/email/'.$respUser->email);
        $this->visit('http://localhost/surveyComplete/1/email/'.$respUser->email);
        $this->see('You have already submitted your response'); 
    }

    public function testShouldNotCompleteSurveyResponseForNewUserWithInvalidEmail()
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

        $response = $this->action('GET', 'Auth\SurveyAuthController@newUserCompleteSurvey', ['surveyId' => $survey->id, 'email' => 'newanonymoususer@user.com']);

        $this->see('Please fill out your answers for the survey');
        
        $ans = array('answer'=>'1');

        $response = $this->action('POST', 'SurveyController@newUserSurveyResponse', ['question1' => 1, 'answer' => $ans, 'email' => 'newanonymoususer.com']);
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('http://localhost/surveyComplete/1/email/newanonymoususer@user.com');
        $this->visit('http://localhost/surveyComplete/1/email/newanonymoususer@user.com');
        $this->see('Invalid email id entered'); 
    }
}
