<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesToAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('request_forms', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('budget_categories', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('request_forms', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('budget_categories', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
