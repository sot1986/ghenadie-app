<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class ShowCommentWithPostTitleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $commentWithPostTitle)
    {
        return response()->json(
            ['data' => $commentWithPostTitle->toArray()]
        );
    }
}

/**
 * [id, title, body, user_id, created_at, updated_at, post_title]
 */
