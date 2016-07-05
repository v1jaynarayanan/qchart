<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationPageTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testNewUserRegistration()
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
}
