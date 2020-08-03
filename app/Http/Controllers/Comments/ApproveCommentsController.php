<?php

namespace App\Http\Controllers\Comments;

use App\Comment;
use App\Http\Controllers\Controller;

class ApproveCommentsController extends Controller
{
    /**
     * @param Comment $comment
     */
    public function index(Comment $comment)
    {
        $comment->verify();

        return response([], 201);
    }

    /**
     * @param Comment $comment
     */
    public function destroy(Comment $comment)
    {
        $comment->unverify();

        return response([], 201);
    }
}
