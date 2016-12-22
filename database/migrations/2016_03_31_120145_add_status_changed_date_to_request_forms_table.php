<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusChangedDateToRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_forms', function (Blueprint $table) {
            $table->dateTime('status_changed_at');
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
            $table->dropColumn('status_changed_at');
        });
    }
}
