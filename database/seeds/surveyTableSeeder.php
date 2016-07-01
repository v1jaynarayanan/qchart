<?php

use Illuminate\Database\Seeder;

class SurveyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//creating new survey 
        \App\Survey::create([
            'user_id' => '1',
            'title' => 'Habits',
            'slug' => 'habits',
            'description' => 'Survey to get all user habits like drinking, swimming etc',
            'status' => 1,
        ]);

        \App\Survey::create([
            'user_id' => '2',
            'title' => 'Tastes',
            'slug' => 'Tastes',
            'description' => 'Survey to get all tastes',
            'status' => 1,
        ]);

        \App\Survey::create([
            'user_id' => '1',
            'title' => 'Sprint1 Retrospective',
            'slug' => 'Sp1 Retro',
            'description' => 'Survey to get feedback on what went well and what did not for Sprint 1',
            'status' => 0,
        ]);
    }
}
