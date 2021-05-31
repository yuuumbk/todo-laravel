<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(100)->create();
        // Folder::factory(500)->create();
        // Task::factory(2000)->create();

        $this->call([
        UserSeeder::class,
        FolderSeeder::class,
        TaskSeeder::class,
    ]);
    }
}
