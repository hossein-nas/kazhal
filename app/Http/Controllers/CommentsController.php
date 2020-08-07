<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Rules\validString;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    /**
     * Description about :: store ::
     */
    public function store(CommentRequest $request)
    {
        Comment::create($request->validated());

        if ($request->expectsJson()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'comment_added_successfully',
                'text'    => 'دیدگاه شما با موفقیت افزوده شد. پس از تائید به نمایش خواهد آمد',
                'data'    => $request->validated(),
            ], 201);
        }

        return response([], 201)->with(['flash' => 'دیدگاه شما با موفقیت افزوده شد. پس از تائید به نمایش خواهد آمد']);
    }

    /**
     * @param Comment $comment
     */
    public function show(Comment $comment)
    {
        if (request()->expectsJson()) {
            return response()->json($comment, 201);
        }

        return response($comment, 201);
    }

    /**
     * @return mixed
     */
    public function index()
    {
        if (request()->has("all") && request()->get('all') === '1') {
            $comments = Comment::withoutGlobalScope('verified')->get();
        } else

        if (request()->has("unapproved") && request()->get('unapproved') === '1') {
            $comments = Comment::withoutGlobalScope('verified')->whereVerified('0')->get();
        } else

        if (request()->has("own") && request()->get('own') === '1') {
            $comments = Comment::withoutGlobalScope('verified')->whereVerified('1')->where('verified_by', auth('api')->id())->get();
        } else {
            $comments = Comment::all();
        }

        return $comments;
    }

    public function update (Comment $comment)
    {
        $data= request()->validate([
            'body' => ['required', 'min:10', 'max:500', new \App\Rules\validString],
        ]);

        $comment->update($data);

        return response([], 201);
    }
}
