<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('budget_manager_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_manager_id')->unsigned();
            $table->integer('budget_category_id')->unsigned();

            $table->foreign('budget_manager_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('budget_category_id')->references('id')->on('budget_categories')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('budget_manager_categories');
        Schema::drop('budget_categories');
    }
}
