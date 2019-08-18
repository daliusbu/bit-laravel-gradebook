<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UsersTableSeeder::class);
        factory('App\Lecture', 5)->create();
        factory('App\Student', 5)->create();
        factory('App\Grade', 10)->create();
        factory('App\User', 3)->create();
        DB::table('users')
            ->updateOrInsert(
                [
                    'email' => 'theking',
                ],
                [
                    'name' => 'King Kong',
                    'email' => 'theking',
                    'password' => Hash::make('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
    }
}
