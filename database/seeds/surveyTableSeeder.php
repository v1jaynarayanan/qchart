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
    }
}
