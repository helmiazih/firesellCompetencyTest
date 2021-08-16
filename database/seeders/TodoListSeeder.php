<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodoListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('todo_lists')->insert([
            ['id' => 1,
            'body' => 'Go to market',
            'is_complete' => 0,
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()],
        ]);
    }
}
