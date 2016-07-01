<?php

use Illuminate\Database\Seeder;

class SurveyAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create answers
		//first user
		\App\SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => '1',
			'answer' => '65',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => '2',
			'answer' => '59',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => '3',
			'answer' => '90',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => '4',
			'answer' => '81',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => '5',
			'answer' => '56',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => '6',
			'answer' => '40',
        ]);		
		//second user
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '1',
			'answer' => '23',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '2',
			'answer' => '40',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '3',
			'answer' => '76',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '4',
			'answer' => '66',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '5',
			'answer' => '87',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '6',
			'answer' => '99',
        ]);
		//third user
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '1',
			'answer' => '95',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '2',
			'answer' => '99',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '3',
			'answer' => '60',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '4',
			'answer' => '81',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '5',
			'answer' => '56',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '6',
			'answer' => '30',
        ]);
    }
}
