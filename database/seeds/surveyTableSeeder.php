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

        \App\Survey::create([
            'user_id' => '1',
            'title' => 'Sprint2 Retrospective',
            'slug' => 'Sp2 Retro',
            'description' => 'Survey to get feedback on what went well and what did not for Sprint 2',
            'status' => 1,
        ]);

        \App\Survey::create([
            'user_id' => '1',
            'title' => 'Sprint3 Retrospective',
            'slug' => 'Sp3 Retro',
            'description' => 'Survey to get feedback on what went well and what did not for Sprint 3',
            'status' => 1,
        ]);

        \App\Survey::create([
            'user_id' => '1',
            'title' => 'Sprint4 Retrospective',
            'slug' => 'Sp4 Retro',
            'description' => 'Survey to get feedback on what went well and what did not for Sprint 4',
            'status' => 1,
        ]);

        \App\Survey::create([
            'user_id' => '1',
            'title' => 'Sprint5 Retrospective',
            'slug' => 'Sp5 Retro',
            'description' => 'Survey to get feedback on what went well and what did not for Sprint 5',
            'status' => 1,
        ]);

        \App\Survey::create([
            'user_id' => '1',
            'title' => 'Sprint6 Retrospective',
            'slug' => 'Sp6 Retro',
            'description' => 'Survey to get feedback on what went well and what did not for Sprint 6',
            'status' => 1,
        ]);

        \App\Survey::create([
            'user_id' => '1',
            'title' => 'Sprint7 Retrospective',
            'slug' => 'Sp7 Retro',
            'description' => 'Survey to get feedback on what went well and what did not for Sprint 7',
            'status' => 1,
        ]);
    }
}
