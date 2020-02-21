<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    protected $req;
    protected $resp;
    protected $attrs;
    protected $post;

    public function getAllPosts()
    {
        $posts = Post::with('author')->with('thumb')->get();
        return response()->json($posts->toArray());
    }

    public function getSinglePost($id){
        $post = Post::findOrFail($id);
        $res = [
            'post' => [
                'id'        => $post->id,
                'title'     => $post->title,
                'content'   => $post->content,
                'slug'      => $post->slug,
                'author'      => $post->author,
                'published'      => $post->published,
                'post_type'      => $post->post_type,
            ],
            'thumbnail' => [
                'id'        => $post->thumb->id,
                'ext'       => $post->thumb->ext,
                'specs'     => $post->thumb->specs
            ],
            'categories' => $post->categories()->get()->pluck('id'),
            'tags' => []
        ];
        return response()->json($res);
    }

    public function add(Request $request)
    {
        $this->req = $request;

        // codes for Validated Params
        if($this->validateParams()){
            $this->addAuthor();
            $this->persistPost();
            $this->addCategories();
            return response()->json($this->resp);
        }
        // response for false data
        return response()->json($this->resp);
    }

    private function validateParams()
    {
        $params = $this->req->all();
        $validate = Validator::make($params, [
            'title'            => 'required|min:10',
            'slug'             => 'required|min:10',
            'content'          => 'required|min:15',
            'published'        => 'boolean',
            'post_type'        => 'required|numeric',
            'categories'       => 'required|array',
            'thumbnail_id'     => 'required|numeric',
        ]);

        if( $validate->fails() ){
            $this->resp = [
                'status' => 'error',
                'message' => 'there_is_an_adding_post',
                'text' => 'خطایی در ثبت اطلاعات پست به وجود آمد.',
                'data' => $validate->errors()
            ];
            return false;
        }
        $this->attrs = $validate->validated();
        return true;
    }

    private function addAuthor()
    {
        $this->attrs['user_id'] = auth()->user()->id;
    }

    private function addCategories()
    {
        $this->post->categories()->sync($this->attrs['categories']);
    }

    private function persistPost()
    {
        $post = new \App\Post();
        $post->fill($this->attrs)->save();
        $this->post = $post;

        $this->resp = [
            'status' => 'ok',
            'message' => 'post_successfuly_added.',
            'text'  => 'پست با موفقیت افزوده شد.',
            'data' => $post
        ];
    }
}
