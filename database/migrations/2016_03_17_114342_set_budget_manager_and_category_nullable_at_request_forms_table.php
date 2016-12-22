<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetBudgetManagerAndCategoryNullableAtRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_forms', function (Blueprint $table) {
            $table->integer('budget_manager_id')->unsigned()->nullable()->change();
            $table->integer('budget_category_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_forms', function (Blueprint $table) {
            $table->integer('budget_manager_id')->unsigned()->change();
            $table->integer('budget_category_id')->unsigned()->change();
        });
    }
}
