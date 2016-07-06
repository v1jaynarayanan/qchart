<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class DashboardPageTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testSeeDashboard(){

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
                    'description' => 'Test Survey 1',
                    'status' => 1]);

    $this->actingAs($user)
         ->visit('/home')
         ->see('Survey Dashboard')
         ->see('Test Survey 1');
    }
}
