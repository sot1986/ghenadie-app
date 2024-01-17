<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 2 images for each post

        // Post::all()->each(function (Post $post) {
        //     $post->images()->createMany(
        //         \Database\Factories\ImageFactory::new()->count(2)->make()->toArray()
        //     );
        // });

        // Create 3 images for each comment

        // \App\Models\Comment::all()->each(function (\App\Models\Comment $comment) {
        //     $comment->images()->createMany(
        //         \Database\Factories\ImageFactory::new()->count(3)->make()->toArray()
        //     );
        // });

        // Create 1 image for each user

        \App\Models\User::all()->each(function (\App\Models\User $user) {
            $user->images()->createMany(
                \Database\Factories\ImageFactory::new()->count(1)->make()->toArray()
            );
        });
    }
}
