<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            'name' => 'admin',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'full_name' => 'John Doe',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ];

        $adminUser = AdminUser::create($admin);

        $guests = [
            [
                'name' => 'guest',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'full_name' => 'John Doe',
                'email' => 'guest@example.com',
                'password' => bcrypt('guest123'),
            ],
        ];

        foreach ($guests as $data) {
            $admin = AdminUser::create($data);
        }
    }
}
