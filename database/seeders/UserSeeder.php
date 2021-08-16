<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['id' => 1,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('abcd1234'),
            'role'=> 'admin',
            'created_at' => now(),
            'updated_at' => now()],
            ['id' => 2,
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('abcd1234'),
            'role'=> 'user',
            'created_at' => now(),
            'updated_at' => now()],
        ]);
    }
}
