<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class PostsController extends Controller
{
    public function getAllPosts()
    {
        $posts = Post::with('author')->with('thumb')->get();
        return response()->json($posts->toArray());
    }

    public function getSinglePost($id){
        $post = Post::findOrFail($id)->first();
        $res = [
            'post' => $post,
        ];
        return response()->json($res);
    }
}
