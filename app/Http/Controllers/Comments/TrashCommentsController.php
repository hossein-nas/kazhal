<?php

namespace App\Http\Controllers\Comments;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrashCommentsController extends Controller
{

    public function store(Comment $comment)
    {
        $comment->trash();

        return response([], 201);
    }

    public function destroy(Comment $comment)
    {
        $comment->untrash();

        return response([], 201);
    }
}
