<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 250; $i++){
          DB::table('tasks')->insert([
            'user_id' => 1,
            'folder_id' => random_int(1,20),
            'title' => 'サンプルタスク' . $i,
            'status' => random_int(0,2),
            'due_date' => date('Y-m-d', rand(strtotime(now()), strtotime('2025-03-31'))),
          ]);
        }
    }
}
