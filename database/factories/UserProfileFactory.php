<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userId = User::all()->random()->id;
        $user = User::find($userId);
        return [
            'user_id' => $userId,
            'first_name' => explode(' ', $user->full_name)[0],
            'last_name' => explode(' ', $user->full_name)[1],
            'middle_name' => $this->faker->firstName(),
            'birth_date' => $this->faker->date(),
            'description' => $this->faker->text(),
            'job_title' => $this->faker->jobTitle(),
            'gender' => 'female',
            'phone_country_code' => 'TW',
            'phone_country_calling_code' => $this->faker->numerify('+886'),
            'phone' => '0422000000',
            'nationality' => $this->faker->country(),
            'identity_code' => $this->faker->numerify('########'),
        ];
    }
}
