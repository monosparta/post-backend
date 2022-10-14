<?php

namespace Database\Factories;

use App\Models\User;
use App\Enums;
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
        return [
            'user_id' => User::all()->random()->id,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'middle_name' => $this->faker->firstName(),
            'birth_date' => $this->faker->date(),
            'job_title' => $this->faker->jobTitle(),
            'gender' => collect(Enums\Gender::cases())->random()->value,
            'phone_country_code' => 'TW',
            'phone_country_calling_code' => $this->faker->numerify('+886'),
            'phone' => '0422000000',
            'nationality' => $this->faker->country(),
            'identity_code' => $this->faker->numerify('########'),
            'note' => $this->faker->text(),
        ];
    }
}
