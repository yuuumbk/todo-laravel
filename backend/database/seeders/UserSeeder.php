<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    DB::table('users')->insert([
      'name' => 'test_user',
      'email' => 'test@example.com',
      'password' => Hash::make('todo-laravel'),
    ]);
  }
}
