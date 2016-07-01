<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Survey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the `Survey` table
        Schema::create('survey', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->unsignedInteger('user_id')->nullable()->comment = "created by";
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->enum('status', ['0', '1'])->comment = "0=disabled, 1= enabled";
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
        //drop table
        Schema::drop('survey');
    }
}
