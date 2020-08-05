<?php

namespace App\Http\Controllers\Comments;

use App\Comment;
use Illuminate\Http\Request;
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

    public function bulk(Request $request)
    {
        $request->validate([
            'comments'   => 'required|array',
            'comments.*' => 'integer',
        ]);

        Comment::withoutGlobalScope('verified')
            ->whereIn('id', $request->input('comments'))
            ->update(['verified' => 1, 'verified_by' => auth()->id()]);

        return response([], 201);
    }

}
