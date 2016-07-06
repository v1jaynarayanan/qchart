<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class LoginPageTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testInactiveUserLogin()
    {
        $user = factory(App\User::class)->create([
                    'name' => 'newuser',
                    'email' => 'newuser@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);

        $this->visit('/login')
             ->see('Login')
             ->seePageIs('/login')
             ->type('newuser@user.com', 'email')
             ->type('passw0RD', 'password')
             ->press('Login')
             ->see('Login');
    }

    public function testActiveUserLogin()
    {
        $user = factory(App\User::class)->create([
                    'name' => 'newuser1',
                    'email' => 'newuser1@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 1,
                    'admin' => 0]);

        $this->visit('/login')
             ->see('Login')
             ->seePageIs('/login')
             ->type('newuser1@user.com', 'email')
             ->type('passw0RD', 'password')
             ->press('Login')
             ->see('Survey Dashboard');
    }

    public function testLoginViaEmailAuthentication(){

         $user = factory(App\User::class)->create([
                    'name' => 'newuser2',
                    'email' => 'newuser2@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);

         $emailLogin = factory(App\EmailLogin::class)->create([
                    'email' => 'newuser2@user.com',
                    'token' => 'test']);
         $survey = factory(App\Survey::class)->create([
                    'user_id' => $user->id,
                    'title' => 'Test Survey',
                    'description' => 'Test Survey',
                    'status' => 1]);

         $response = $this->call('GET', 'auth/email-authenticate/test');

         $this->assertRedirectedTo('home');

    }
}
