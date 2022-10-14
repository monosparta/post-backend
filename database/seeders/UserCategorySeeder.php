<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array('網站會員', '進駐會員', '進駐學員', '訂閱會員', '志工', '員工');

        foreach ($categories as  $category) {
            UserCategory::create([
                'name' => $category,
            ]);
        }

        $categories = UserCategory::all();

        User::all()->each(function($user) use ($categories) {
            $user->userCategories()->attach(
                $categories->random(1)->pluck('id')->toArray()
            );
        });
    }
}
