<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        foreach($posts as $post) {
            $user = $users->random();

            for($i = 1; $i <= 5; $i++) {
                Comment::factory()->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id
                ]);
            }

        }
    }
}
