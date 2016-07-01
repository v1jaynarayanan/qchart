<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SurveyAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('user_id')->nullable()->comment = "created by";
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedInteger('survey_quest_id')->nullable()->comment = "Answer belongs to";
            $table->foreign('survey_quest_id')->references('id')->on('survey_questions')->onDelete('set null');
            $table->unsignedInteger('answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('survey_answers');
    }
}
