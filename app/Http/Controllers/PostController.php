<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Comment::query()->whereIn('post_id', [10,1,...,12,14])->get();
        return Inertia::render('Posts/List', [
            'result' => Comment::query()
                ->addSelect([
                    'post_title' => Post::query()
                        ->select('title')
                        ->whereColumn('id', 'comments.post_id')
                        ->limit(1),
                ])
                ->paginate(100),
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
