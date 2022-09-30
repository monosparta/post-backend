<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmergencyContact>
 */
class EmergencyContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'mobile_country_code' => 'TW',
            'mobile_country_calling_code' => $this->faker->numerify('+886'),
            'mobile' => $this->faker->unique()->numerify('9########'),
            'relationship' => $this->faker->randomElement(['Father', 'Mother', 'Brother', 'Sister', 'Friend', 'Other']),
        ];
    }
}
