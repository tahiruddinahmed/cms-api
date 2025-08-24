<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();

        for($i = 1; $i <= 30; $i++) {
            // create 
            $user = $users->random();
            $category = $categories->random();

            Post::factory()->create([
                'user_id' => $user->id,
                'category_id' => $category->id
            ]);
        }
    }
}
