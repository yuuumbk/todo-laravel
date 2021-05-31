<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //   'id' => 1,
        //   'name' => 'test_user',
        //   'email' => 'test@example.com',
        //   'email_verified_at' => now(),
        //   'password' => '12345678',
        //   'remember_token' => Str::random(10),
        // ]);
        DB::table('users')->insert([
          'id' => 1,
          'name' => 'test_user',
          'email' => 'test@example.com',
          'email_verified_at' => now(),
          'password' => '12345678',
          'remember_token' => Str::random(10),
        ]);

        // Folder::create([
        //   'id' => 1,
        //   'user_id' => 1,
        //   'title' => 'サンプルフォルダ1',
        // ]);

        DB::table('folders')->insert([
          'id' => 1,
          'user_id' => 1,
          'title' => 'サンプルフォルダ1',
        ]);

        // Task::create([
        //   'id' => 1,
        //   'user_id' => 1,
        //   'folder_id' => 1,
        //   'title' => 'サンプルタスク1',
        //   'status' => 1,
        //   'due_date' => now(),
        // ]);

        DB::table('tasks')->insert([
          'id' => 1,
          'user_id' => 1,
          'folder_id' => 1,
          'title' => 'サンプルタスク1',
          'status' => 1,
          'due_date' => now(),
        ]);
    }
}
