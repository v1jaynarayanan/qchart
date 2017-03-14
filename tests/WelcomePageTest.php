<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WelcomePageTest extends TestCase
{
    public function testWelcomePage()
    {
        $this->visit('/')
             ->see('Feedback360 is a free, simple and fast tool that helps you to');
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
