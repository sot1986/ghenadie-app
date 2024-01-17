<?php

namespace App\Listeners;

use App\Events\PostDelete;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeletePostImages implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostDelete $event): void
    {
        Image::query()
            ->where('imageable_id', $event->postId)
            ->where('imageable_type', Post::class)
            ->delete();
    }
}
