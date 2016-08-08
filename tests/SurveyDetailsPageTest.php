<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use App\SurveyQuestions;
use App\SurveyAnswers;

class SurveyDetailsPageTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testShouldShowSurveyDetailsPage()
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
        
        $this->actingAs($user)
             ->visit('/home')
             ->see('Survey Dashboard')
             ->see('Test Survey')
             ->click('Test Survey')
             ->see('Survey Details');
    }

    public function testShouldNotCloseSurvey()
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
        
        $this->actingAs($user)
             ->visit('/home')
             ->see('Survey Dashboard')
             ->see('Test Survey')
             ->click('Test Survey')
             ->see('SURVEY DETAILS')
             ->click('deleteSelected')
             ->click('cancelBtn')
             ->see('SURVEY DETAILS');   
    }

    public function testShouldCloseSurvey()
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
        
        $this->actingAs($user);
        $response = $this->action('POST', 'HomeController@closeSurvey', ['surveyId' => $survey->id,]);

        $surveyDetails = App\Survey::find($survey->id);
        $this->assertEquals(0,$surveyDetails->status);
    }

    public function testShouldGenerateGraph()
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

        $question1 = SurveyQuestions::where('question', '=', 'Test Q1')->first();
        
        SurveyAnswers::create([
            'user_id' => '1',
            'survey_quest_id' => $question1->id,
            'answer' => '60',
        ]);
        
        SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => $question1->id,
            'answer' => '60',
        ]);

        $this->actingAs($user);
        $response = $this->action('GET','SurveyController@drawGraph', ['surveyId' => $survey->id]);
        $this->see('Survey Results');
    }
}
