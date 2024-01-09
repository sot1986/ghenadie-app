<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create()
            ->each(function (User $user) {
                Post::factory(5)->create([
                    'user_id' => $user->id,
                ])->each(function (Post $post) {
                    $this->createComment($post);
                    $this->createComment($post);
                    $this->createComment($post);
                    $this->createComment($post);
                    $this->createComment($post);
                });
            });
    }

    protected function createComment(Post $post)
    {
        $user = User::query()->inRandomOrder()->first();
        Comment::factory(10)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        $user = User::query()->inRandomOrder()->first();
        Comment::factory(10)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        $user = User::query()->inRandomOrder()->first();
        Comment::factory(10)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        $user = User::query()->inRandomOrder()->first();
        Comment::factory(10)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }
}
