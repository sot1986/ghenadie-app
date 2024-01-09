<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        Route::bind('comment_with_post_title', function (string $value) {

            /**
             * SELECT 
             * comments.*, 
             * (SELECT title FROM posts WHERE posts.id = comments.post_id LIMIT 1) AS post_title
             * FROM comments
             * WHERE comments.id = 1
             * LIMIT 1
             */

            return Comment::query()
                ->with('post:id,title')
                ->addSelect([
                    'post_title' => Post::query()
                        ->select('title')
                        ->whereColumn('posts.id', 'comments.post_id')
                        ->limit(1),
                ])
                ->firstOrFail();
        });
    }
}
