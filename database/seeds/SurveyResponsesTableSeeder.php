<?php

use Illuminate\Database\Seeder;

class SurveyResponsesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\SurveyResponses::create([
            'survey_id' => '1',
            'email' => 'user1@user.com',
            'status' => '0',
        ]);
        \App\SurveyResponses::create([
            'survey_id' => '1',
            'email' => 'user2@user.com',
            'status' => '0',
        ]);

        \App\SurveyResponses::create([
            'survey_id' => '1',
            'email' => 'user3@user.com',
            'status' => '1',
        ]);
    }
}
