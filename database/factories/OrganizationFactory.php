<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
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
            'name' => $this->faker->unique()->company(),
            'vat' => $this->faker->numerify('########'),
            'phone_country_code' => 'TW',
            'phone_country_calling_code' => $this->faker->numerify('+886'),
            'phone' => '0422000000',
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
