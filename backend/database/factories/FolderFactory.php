<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Factories\Factory;

class FolderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Folder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = User::all('id');
        return [
            'user_id' => $this->faker->randomElement($user_id),
            'title' => $this->faker->words(1, true),
        ];
    }
}
