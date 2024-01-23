<?php

namespace App\Http\Controllers;

use App\Events\PostDelete;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use App\Rules\SpecialPostRule;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = request()->user();
        // $user->is_admin = true;
        // $user->save();

        // Comment::query()->whereIn('post_id', [10,1,...,12,14])->get();
        return Inertia::render('Posts/List', [
            'posts' => Post::get(),
            'deleted_posts' => Post::onlyTrashed()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Post::create(
            [
                ...$request->validate([
                    'title' => ['required', 'string'],
                    'body' => ['required', 'string'],
                ]),
                'user_id' => $request->user()->id,
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    public function special(Request $request)
    {
        $data = $request->validate([
            'special' => ['required', new SpecialPostRule],
        ]);

        dd($data);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index');
    }

    public function restore(Request $request, string $post)
    {
        $post = Post::withTrashed()->findOrFail($post);

        $post->restore();

        return redirect()->route('posts.index');
    }

    public function forceDelete(Request $request, string $post)
    {

        $post = Post::withTrashed()->findOrFail($post);

        $this->authorize('forceDelete', $post);

        $post->forceDelete();

        return redirect()->route('posts.index');
    }
}
