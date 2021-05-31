<?php

namespace Database\Factories;

use App\Models\Folder;
use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = User::all('id');
        $folder_id = Folder::all('id');
        return [
            'user_id' => $this->faker->randomElement($user_id),
            'folder_id' => $this->faker->randomElement($folder_id),
            'title' => $this->faker->words(1, true),
            // 'status' => $this->faker->randomElement([0, 1, 2]),
            'due_date' => $this->faker->dateTimeBetween('now', '+1year'),
        ];
    }
}
