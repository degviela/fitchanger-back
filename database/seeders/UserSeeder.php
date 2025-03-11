<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'firstName' => 'Ralfs',
                'lastName' => 'Gulbis',
                'username' => 'example',
                'email' => 'hagijss54@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$OPnurDsKVVS/WIwL35qR3.1F0MRSEPFFXB/qXiezZ0OSJMFgnfzR.',
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}

