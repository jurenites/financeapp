<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('type');
            $table->string('payment_method');
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('payable_to_name');
            $table->string('payable_to_type');
            $table->float('amount');
            $table->text('explanation');
            $table->integer('budget_manager_id')->unsigned();
            $table->integer('budget_category_id')->unsigned();
            $table->text('requester_notes');
            $table->text('budget_manager_notes');
            $table->text('admin_notes');
            $table->string('status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('budget_manager_id')->references('id')->on('users');
            $table->foreign('budget_category_id')->references('id')->on('budget_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('request_forms');
    }
}
