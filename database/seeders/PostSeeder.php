<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()->create([
            'id' => 'ffffffff-ffff-ffff-ffff-ffffffffffff'
        ]);

        Post::factory()->create([
            'id' => '00000000-0000-0000-0000-000000000000'
        ]);
        Post::factory(10)->create();
    }
}
