<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SurveyResponses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('survey_id')->comment = "Response belongs to Survey";
            $table->foreign('survey_id')->references('id')->on('survey')->onDelete('cascade');
            $table->string('email')->comment = "Survey sent to";
            $table->enum('status', ['0', '1'])->default(0)->comment = "0=not responded, 1= responded";
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
        Schema::drop('survey_responses');
    }
}
