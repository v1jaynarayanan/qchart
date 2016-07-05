<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WelcomePageTest extends TestCase
{
    public function testWelcomePage()
    {
        $this->visit('/')
             ->see('WELCOME TO QCHART');
    }

    public function testClickLogin()
    {
        $this->visit('/')
             ->click('Login')
             ->seePageIs('/login')
             ->see('Login');
    }

    public function testClickRegister()
    {
        $this->visit('/')
             ->click('Register')
             ->seePageIs('/register')
             ->see('Register');
    }
}
