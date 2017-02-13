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
             ->see('My Surveys')
             ->see('Test Survey')
             ->click('Test Survey')
             ->see('Survey Details');
    }

    public function testShouldShowSurveyProgressForSurvey()
    {
        $user = factory(App\User::class)->create([
                    'name' => 'newuser5',
                    'email' => 'newuser5@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);
        
        $user1 = factory(App\User::class)->create([
                    'name' => 'newuser1',
                    'email' => 'testuser1@test.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);

        $user2 = factory(App\User::class)->create([
                    'name' => 'newuser2',
                    'email' => 'testuser2@test.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);

        $user3 = factory(App\User::class)->create([
                    'name' => 'newuser3',
                    'email' => 'testuser3@test.com',
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
        $surveyResponse1 = factory(App\SurveyResponses::class)->create([
                    'survey_id' => $survey->id,
                    'email' => 'testuser1@test.com',
                    'status' => 1]);
        
        $surveyResponse2 = factory(App\SurveyResponses::class)->create([
                    'survey_id' => $survey->id,
                    'email' => 'testuser2@test.com',
                    'status' => 0]);

        $surveyResponse3 = factory(App\SurveyResponses::class)->create([
                    'survey_id' => $survey->id,
                    'email' => 'testuser3@test.com',
                    'status' => 1]);

        $this->actingAs($user);

        $response = $this->action('GET', 'HomeController@surveyDetails', ['surveyId' => $survey->id,]);

        $this->see('Survey Details')
             ->see('Survey Progress')
             ->see('Survey Participants')
             ->see('testuser1@test.com')
             ->see('testuser2@test.com')
             ->see('testuser3@test.com');
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
             ->see('My Surveys')
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
        
        $this->withoutMiddleware();
        $this->actingAs($user);
        $response = $this->action('POST', 'HomeController@closeSurvey', ['surveyId' => $survey->id,]);

        $surveyDetails = App\Survey::find($survey->id);
        $this->assertEquals(0,$surveyDetails->status);
    }

    public function testShouldGenerateGraph()
    {
        $adminUser = factory(App\User::class)->create([
                    'name' => 'admuser1',
                    'email' => 'admuser1@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 1,
                    'admin' => 0]);

        $survey = factory(App\Survey::class)->create([
                    'user_id' => $adminUser->id,
                    'title' => 'Test Survey',
                    'slug' => 'Test Survey',
                    'description' => 'Test Survey',
                    'status' => 1]);
       
        $user1 = factory(App\User::class)->create([
                    'name' => 'newuser1',
                    'email' => 'newuser1@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);

        $user2 = factory(App\User::class)->create([
                    'name' => 'newuser2',
                    'email' => 'newuser2@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);

        SurveyQuestions::create([
            'user_id' => $adminUser->id,
            'survey_id' => $survey->id,
            'question' => 'Test Q1',
        ]);

        $question1 = SurveyQuestions::where('question', '=', 'Test Q1')->first();
        
        SurveyAnswers::create([
            'user_id' => $user1->id,
            'answered_by' => 'User 1',
            'survey_quest_id' => $question1->id,
            'answer' => '60',
        ]);
        
        SurveyAnswers::create([
            'user_id' => $user2->id,
            'answered_by' => 'User 2',
            'survey_quest_id' => $question1->id,
            'answer' => '60',
        ]);

        $this->actingAs($adminUser);
        $response = $this->action('GET','SurveyController@drawGraph', ['surveyId' => $survey->id]);
        $this->see('Survey Results');
    }
}
