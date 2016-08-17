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
            'answered_by' => 'Normal User1',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => '2',
			'answer' => '59',
            'answered_by' => 'Normal User1',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => '3',
			'answer' => '90',
            'answered_by' => 'Normal User1',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => '4',
			'answer' => '81',
            'answered_by' => 'Normal User1',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => '5',
			'answer' => '56',
            'answered_by' => 'Normal User1',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '2',
            'survey_quest_id' => '6',
			'answer' => '40',
            'answered_by' => 'Normal User1',
        ]);		
		//second user
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '1',
			'answer' => '23',
            'answered_by' => 'Anonymous',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '2',
			'answer' => '40',
            'answered_by' => 'Anonymous',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '3',
			'answer' => '76',
            'answered_by' => 'Anonymous',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '4',
			'answer' => '66',
            'answered_by' => 'Anonymous',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '5',
			'answer' => '87',
            'answered_by' => 'Anonymous',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '3',
            'survey_quest_id' => '6',
			'answer' => '99',
            'answered_by' => 'Anonymous',
        ]);
		//third user
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '1',
			'answer' => '95',
            'answered_by' => 'Normal User2',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '2',
			'answer' => '99',
            'answered_by' => 'Normal User2',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '3',
			'answer' => '60',
            'answered_by' => 'Normal User2',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '4',
			'answer' => '81',
            'answered_by' => 'Normal User2',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '5',
			'answer' => '56',
            'answered_by' => 'Normal User2',
        ]);
		\App\SurveyAnswers::create([
            'user_id' => '4',
            'survey_quest_id' => '6',
			'answer' => '30',
            'answered_by' => 'Normal User2',
        ]);
    }
}
