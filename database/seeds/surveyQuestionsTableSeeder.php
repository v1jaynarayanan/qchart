<?php

use Illuminate\Database\Seeder;

class SurveyQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create survey question
		\App\SurveyQuestions::create([
            'user_id' => '1',
            'survey_id' => '1',
            'question' => 'Eating',
        ]);
		\App\SurveyQuestions::create([
            'user_id' => '1',
            'survey_id' => '1',
            'question' => 'Sleeping',
        ]);
		\App\SurveyQuestions::create([
            'user_id' => '1',
            'survey_id' => '1',
            'question' => 'Drinking',
        ]);
		\App\SurveyQuestions::create([
            'user_id' => '1',
            'survey_id' => '1',
            'question' => 'Coding',
        ]);
		\App\SurveyQuestions::create([
            'user_id' => '1',
            'survey_id' => '1',
            'question' => 'Cycling',
        ]);
		\App\SurveyQuestions::create([
            'user_id' => '1',
            'survey_id' => '1',
            'question' => 'Running',
        ]);
    }
}
