<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');
            $table->string('type');
            $table->integer('request_form_id')->unsigned();
            $table->integer('author_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('request_form_id')->references('id')->on('request_forms');
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::table('request_forms', function (Blueprint $table) {
            $table->dropColumn('requester_notes');
            $table->dropColumn('budget_manager_notes');
            $table->dropColumn('admin_notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notes');
        Schema::table('request_forms', function (Blueprint $table) {
            $table->text('requester_notes');
            $table->text('budget_manager_notes');
            $table->text('admin_notes');
        });
    }
}
