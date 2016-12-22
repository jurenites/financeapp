<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCashRequestTypeToRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_forms', function (Blueprint $table) {
            $table->string('cash_request_type');
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
            $table->dropColumn('cash_request_type');
        });
    }
}
