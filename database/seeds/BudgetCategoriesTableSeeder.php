<?php

use Illuminate\Database\Seeder;

class BudgetCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('budget_categories')->truncate();
        DB::table('budget_categories')->insert([
            'name' => '7598 - Facilities',
        ]);
        DB::table('budget_categories')->insert([
            'name' => '65221 - Barracks Row AC',
        ]);
        DB::table('budget_categories')->insert([
            'name' => '65278 - 7th ST Maintenance',
        ]);
        DB::table('budget_categories')->insert([
            'name' => '6555 - Media',
        ]);
        DB::table('budget_categories')->insert([
            'name' => '6588 - NCC Operations',
        ]);
        DB::table('budget_categories')->insert([
            'name' => '6588a - HR',
        ]);
        DB::table('budget_categories')->insert([
            'name' => '6532 - Missions',
        ]);
        DB::table('budget_categories')->insert([
            'name' => '1234 - Campus Ministries',
        ]);

        DB::table('budget_manager_categories')->truncate();
        DB::table('budget_manager_categories')->insert([
            'budget_manager_id' => 3,
            'budget_category_id' => 1
        ]);
        DB::table('budget_manager_categories')->insert([
            'budget_manager_id' => 3,
            'budget_category_id' => 2
        ]);
        DB::table('budget_manager_categories')->insert([
            'budget_manager_id' => 3,
            'budget_category_id' => 3
        ]);
        DB::table('budget_manager_categories')->insert([
            'budget_manager_id' => 4,
            'budget_category_id' => 4
        ]);
        DB::table('budget_manager_categories')->insert([
            'budget_manager_id' => 5,
            'budget_category_id' => 5
        ]);
        DB::table('budget_manager_categories')->insert([
            'budget_manager_id' => 5,
            'budget_category_id' => 6
        ]);
        DB::table('budget_manager_categories')->insert([
            'budget_manager_id' => 6,
            'budget_category_id' => 7
        ]);
        DB::table('budget_manager_categories')->insert([
            'budget_manager_id' => 6,
            'budget_category_id' => 8
        ]);
    }
}
