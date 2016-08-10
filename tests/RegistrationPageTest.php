<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class RegistrationPageTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testShouldRegisterNewUser()
    {
        $this->visit('/register')
             ->see('Register')
             ->seePageIs('/register')
             ->type('NewUser1', 'name')
             ->type('NewUser1@User.com', 'email')
             ->type('password', 'password')
             ->type('password', 'password_confirmation')
             ->press('Register')
             ->seeInDatabase('users', ['email' => 'NewUser1@User.com'])
             ->see('Registration confirmation');
    }

    public function testShouldNotRegisterUserWithInvalidEmail()
    {
        $this->visit('/register')
             ->see('Register')
             ->seePageIs('/register')
             ->type('NewUser1', 'name')
             ->type('NewUser1', 'email')
             ->type('password', 'password')
             ->type('password', 'password_confirmation')
             ->press('Register')
             ->see('The email must be a valid email address');
    }

    public function testShouldNotRegisterDuplicateUser()
    {   
        $user = factory(App\User::class)->create([
                    'name' => 'newuser5',
                    'email' => 'newuser5@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);
        $userInDb = User::where('email', '=', 'newuser5@user.com')->first();
        $this->assertEquals('newuser5@user.com', $userInDb->email);
        $this->assertEquals('newuser5', $userInDb->name);

        $this->visit('/register')
             ->see('Register')
             ->seePageIs('/register')
             ->type('NewUser1', 'name')
             ->type('newuser5@user.com', 'email')
             ->type('password', 'password')
             ->type('password', 'password_confirmation')
             ->press('Register')
             ->see('This email has already been taken');
    }

    public function testShouldUpdateUserIfAnonymous()
    {   
        $user = factory(App\User::class)->create([
                    'name' => 'Anonymous',
                    'email' => 'newuser5@user.com',
                    'role_id' => 0,
                    'password' => Hash::make('passw0RD'),
                    'confirmed' => 0,
                    'admin' => 0]);
        $userInDb = User::where('email', '=', 'newuser5@user.com')->first();    
        $this->assertEquals('newuser5@user.com', $userInDb->email);
        $this->assertEquals('Anonymous', $userInDb->name);

        $this->visit('/register')
             ->see('Register')
             ->seePageIs('/register')
             ->type('NewUser', 'name')
             ->type('newuser5@user.com', 'email')
             ->type('password', 'password')
             ->type('password', 'password_confirmation')
             ->press('Register')
             ->see('You have been successfully registered. An email has been sent to your email id for verification.');

        $userInDb = User::where('email', '=', 'newuser5@user.com')->first();    
        $this->assertEquals('newuser5@user.com', $userInDb->email);
        $this->assertEquals('NewUser', $userInDb->name); 
    }
}
