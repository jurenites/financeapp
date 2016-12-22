<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestFormEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_form_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->integer('request_form_id')->unsigned();
            $table->integer('author_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('request_form_id')->references('id')->on('request_forms');
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('request_form_events');
    }
}
