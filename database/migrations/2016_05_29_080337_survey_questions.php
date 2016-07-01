<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SurveyQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('user_id')->nullable()->comment = "created by";
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedInteger('survey_id')->nullable()->comment = "Survey belongs to";
            $table->foreign('survey_id')->references('id')->on('survey')->onDelete('set null');
            $table->string('question');
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
        Schema::drop('survey_questions');
    }
}
