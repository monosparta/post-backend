<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $test = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@trunk-studio.com',
        ]);

        User::factory(50)->create();
    }
}
