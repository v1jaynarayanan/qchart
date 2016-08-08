<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class NewSurveyPageTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testShouldAddNewSurvey(){
        
        $user = factory(App\User::class)->create([
                    'name' => 'newuser4',
                    'email' => 'newuser4@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);
 
        $this->actingAs($user)
             ->visit('/showNewSurveyPage')
             ->see('ADD NEW SURVEY')
             ->type('Test Survey Title', 'surveyTitle')
             ->type('Test Survey Description', 'surveyDescription')
             ->type('Test Question 1', 'question1')
             ->press('addNewSurvey')
             ->see('Create New Survey Confirmation')
             ->see('Your new survey has been created successfully.');
    
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
             ->see('Survey Dashboard')
             ->see('Test Survey')
             ->click('Create New Survey')
             ->see('Add New Survey');
    }
}
