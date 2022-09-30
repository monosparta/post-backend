<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'city' => '台中市',
            'zip_code' => '400',
            'region' => '西區',
            'address_line_1' => '',
            'address_line_2' => '',
            'addressable_id' => 1,
            'addressable_type' => 'App\Models\UserProfile',
        ];
    }
}
