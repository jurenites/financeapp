<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDirectDepositFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bank_name');
            $table->string('account_type');
            $table->string('routing_number');
            $table->string('account_number');
        });

        Schema::table('request_forms', function (Blueprint $table) {
            $table->string('bank_name');
            $table->string('account_type');
            $table->string('routing_number');
            $table->string('account_number');
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
            $table->dropColumn('bank_name');
            $table->dropColumn('account_type');
            $table->dropColumn('routing_number');
            $table->dropColumn('account_number');
        });

        Schema::table('request_forms', function (Blueprint $table) {
            $table->dropColumn('bank_name');
            $table->dropColumn('account_type');
            $table->dropColumn('routing_number');
            $table->dropColumn('account_number');
        });
    }
}
