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
            'id' => 'ffffffff-ffff-ffff-ffff-ffffffffffff',
            'name' => 'Guest',
            'full_name' => 'Guest User',
            'email' => 'test@example.com',
            'mobile' => '905123456'
        ]);

        $test = User::factory()->create([
            'id' => '00000000-0000-0000-0000-000000000000',
            'name' => 'John Doe',
            'full_name' => 'Admin User',
            'email' => 'admin@example.com',
            'mobile' => '99000999'
        ]);

        User::factory(50)->create();
    }
}
