<?php

class TemplateFeedBackTest extends TestCase
{

    public function testFormsCategoryMenu()
    {
        $this->visit('/')
            ->see('Templates');
    }

    public function testCategoryClickLoginPageasGuest()
    {
        $this->visit('/')
            ->click('Agile Sprint Retrospective Feedback')
            ->seePageIs('/login')
            ->see('Login');

        $this->visit('/')
            ->click('Team Assessment Feedback')
            ->seePageIs('/login')
            ->see('Login');

        $this->visit('/')
            ->click('Employee Feedback')
            ->seePageIs('/login')
            ->see('Login');

        $this->visit('/')
            ->click('Customer Satisfaction Feedback')
            ->seePageIs('/login')
            ->see('Login');
        $this->visit('/')
            ->click('Event Planning Feedback')
            ->seePageIs('/login')
            ->see('Login');

        $this->visit('/')
            ->click('Market Research Feedback')
            ->seePageIs('/login')
            ->see('Login');

    }

    public function testCategoryLoginPageasUser()
    {

        $user = factory(App\User::class)->create([
            'name'      => 'newuser1',
            'email'     => 'newuser1@test.com',
            'role_id'   => 0,
            'password'  => Hash::make('google'),
            'confirmed' => 1,
            'admin'     => 0]);

        $this->visit('/')
            ->click('Login')
            ->seePageIs('/login')
            ->type('newuser1@test.com', 'email')
            ->type('google', 'password')
            ->press('Login')
            ->see('ADD NEW SURVEY');

        $this->visit('/')
            ->click('Agile Sprint Retrospective Feedback')->see('Agile Sprint Retrospective');
        $this->visit('/')
            ->click('Team Assessment Feedback')->see('Team Assessment');
        $this->visit('/')
            ->click('Employee Feedback')->see('ADD NEW SURVEY');
        $this->visit('/')
            ->click('Customer Satisfaction Feedback')->see('ADD NEW SURVEY');
        $this->visit('/')
            ->click('Event Planning Feedback')->see('ADD NEW SURVEY');
        $this->visit('/')
            ->click('Market Research Feedback')->see('ADD NEW SURVEY');

    }

    public function testCategoryClickLoginPageasUser()
    {

        $user = factory(App\User::class)->create([
            'name'      => 'newuser1',
            'email'     => 'newuser1@test.com',
            'role_id'   => 0,
            'password'  => Hash::make('google'),
            'confirmed' => 1,
            'admin'     => 0]);

        $this->visit('/')
            ->click('Agile Sprint Retrospective Feedback')
            ->seePageIs('/login')
            ->type('newuser1@test.com', 'email')
            ->type('google', 'password')
            ->press('Login')
            ->see('Agile Sprint Retrospective')
            ->see('Do you think the team delivered all stories as per Sprint commitment?');

        $this->visit('/')
            ->click('Logout')->see('login');

        $this->visit('/')
            ->click('Team Assessment Feedback')
            ->seePageIs('/login')
            ->type('newuser1@test.com', 'email')
            ->type('google', 'password')
            ->press('Login')
            ->see('Team Assessment')
            ->see('Do you think the team produced value to business?');


        $this->visit('/')
            ->click('Logout')->see('login');
        $this->visit('/')
            ->click('Employee Feedback')
            ->seePageIs('/login')
            ->type('newuser1@test.com', 'email')
            ->type('google', 'password')
            ->press('Login')
             ->see('ADD NEW SURVEY')
            ->see('Question 7');


        $this->visit('/')
            ->click('Logout')->see('login');

        $this->visit('/')
            ->click('Customer Satisfaction Feedback')
            ->seePageIs('/login')
            ->type('newuser1@test.com', 'email')
            ->type('google', 'password')
            ->press('Login')
            ->see('ADD NEW SURVEY')
            ->see('Question 7');


        $this->visit('/')
            ->click('Logout')->see('login');

        $this->visit('/')
            ->click('Event Planning Feedback')
            ->seePageIs('/login')
            ->type('newuser1@test.com', 'email')
            ->type('google', 'password')
            ->press('Login')
            ->see('ADD NEW SURVEY')
            ->see('Question 7');


        $this->visit('/')
            ->click('Logout')->see('login');

        $this->visit('/')
            ->click('Market Research Feedback')
            ->seePageIs('/login')
            ->type('newuser1@test.com', 'email')
            ->type('google', 'password')
            ->press('Login')
            ->see('ADD NEW SURVEY')
            ->see('Question 7');


    }

}
