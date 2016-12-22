<?php

use Illuminate\Database\Seeder;

class ClearDataTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('jobs')->truncate();
        DB::table('emails')->truncate();
        DB::table('action_tokens')->truncate();
        DB::table('request_form_events')->truncate();
        DB::table('notes')->truncate();
        DB::table('documents')->truncate();
        DB::table('budget_manager_categories')->truncate();
        DB::table('budget_categories')->truncate();
        DB::table('request_forms')->truncate();
        DB::table('role_user')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
