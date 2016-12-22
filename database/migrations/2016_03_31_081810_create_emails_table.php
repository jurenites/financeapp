<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->text('body');
            $table->string('to_email');
            $table->string('template');
            $table->integer('author_id')->unsigned();
            $table->integer('request_form_id')->unsigned();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('request_form_id')->references('id')->on('request_forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('emails');
    }
}
