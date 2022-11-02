<?php

namespace Database\Factories;

use App\Models\AdminUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userId = AdminUser::all()->random()->id;
        return [
            'title'=>$this->faker->sentence(),
            'content'=>$this->faker->paragraph(),
            'user_id' => $userId,
        ];
    }
}
