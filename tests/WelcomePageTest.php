<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WelcomePageTest extends TestCase
{
    public function testWelcomePage()
    {
        $this->visit('/')
             ->see('WELCOME TO FEEDBACK360');
    }





    public function testShouldShowLoginPage()
    {
        $this->visit('/')
             ->click('Login')
             ->seePageIs('/login')
             ->see('Login');
    }

    public function testShouldShowRegisterPage()
    {
        $this->visit('/')
             ->click('Register')
             ->seePageIs('/register')
             ->see('Register');
    }

 

}
