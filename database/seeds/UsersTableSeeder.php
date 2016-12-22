<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => 'user',
            'phone' => str_random(10),
            'email' => 'user@user.co',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'phone' => str_random(10),
            'email' => 'admin@admin.co',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'Amy Wall',
            'phone' => str_random(10),
            'email' => 'manager1@manager.co',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'Andy Pisciotti',
            'phone' => str_random(10),
            'email' => 'manager2@manager.co',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'Jim Tanious',
            'phone' => str_random(10),
            'email' => 'manager3@manager.co',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'Joel Schmidgall',
            'phone' => str_random(10),
            'email' => 'manager4@manager.co',
            'password' => bcrypt('password'),
        ]);
    }
}
