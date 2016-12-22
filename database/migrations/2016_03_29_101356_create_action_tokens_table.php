<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token');
            $table->string('redirect_url');
            $table->integer('user_id')->unsigned();
            $table->integer('request_form_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('action_tokens');
    }
}
