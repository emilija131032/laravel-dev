<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'email' => 'laravel_admin@gmail.com',
                'name' => 'Admin',
                'password' => bcrypt('TestAdmin123!'),
                'status' => 1,
                'signed_up' => 1,
                'userable_id' => 1,
                'userable_type' => 'Admin',
                'remember_token' => Str::random(10)
            ]
        ];

        DB::table('users')->insert($users);
    }
}
