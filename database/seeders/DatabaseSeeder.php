<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            EnumerateSeeder::class,
            EnumerateItemSeeder::class,

            UserSeeder::class,
            TeamSeeder::class,
            UserCategorySeeder::class,
            AdminUserSeeder::class,
            
            CommentSeeder::class,
        ]);
    }
}
