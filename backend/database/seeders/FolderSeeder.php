<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 25; $i++){
          DB::table('folders')->insert([
            'user_id' => 1,
            'title' => 'サンプルタスク' . $i,
          ]);
        }
    }
}
