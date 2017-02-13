<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class DashboardPageTest extends TestCase
{
    use DatabaseMigrations;

    public function testShouldShowDashboard(){

    $user = factory(App\User::class)->create([
                    'name' => 'newuser3',
                    'email' => 'newuser3@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);

    $survey = factory(App\Survey::class)->create([
                    'user_id' => $user->id,
                    'title' => 'Test Survey 1',
                    'slug' => 'Test Survey 1',
                    'description' => 'Test Survey 1',
                    'status' => 1]);

    $this->actingAs($user)
         ->visit('/home')
         ->see('My Surveys')
         ->see('Test Survey 1');
    }

    public function testShouldViewSurveyDetails(){

        $user = factory(App\User::class)->create([
                    'name' => 'newuser4',
                    'email' => 'newuser4@user.com',
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
             ->visit('/details/'.$survey->id)
             ->see('Survey Details')
             ->see('Test Survey');
    }

    public function testShouldDeleteSurvey(){
        
        $user = factory(App\User::class)->create([
                    'name' => 'newuser4',
                    'email' => 'newuser4@user.com',
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
        $response = $this->action('DELETE', 'HomeController@deleteSurvey', ['cb[]' => $survey->id,]);

        $surveyDetails = App\Survey::find($survey->id);
        assert($surveyDetails == null);
    
    }    

    public function testShouldSendSurveyEmail(){
        
        $user = factory(App\User::class)->create([
                    'name' => 'newuser4',
                    'email' => 'newuser4@user.com',
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
             ->click('Send Survey')
             ->see('Send survey');
        
    }    

    public function testShouldShowNewSurveyPage()
    {
        $user = factory(App\User::class)->create([
                    'name' => 'newuser4',
                    'email' => 'newuser4@user.com',
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
             ->click('Add New Survey')
             ->see('Add New Survey');
    }
}
