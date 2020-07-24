<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Rules\validAlpha;
use App\Rules\validString;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    protected $validator;
    protected $params;
    protected $errors;
    protected $resp;
    protected $done;

    public function create(Request $request)
    {
        $this->validator();

        if ($this->validator->fails()) {
            return response()->json($this->validator->errors(), 400);
        }

        $this->persistComment($this->params);

        if ($this->done) {
            return response()->json($this->resp, 200);
        } else {
            return response()->json($this->errors, 400);
        }
    }

    private function persistComment($params)
    {
        $params = $this->translateParams($params);
        $cm = new Comment();
        $cm->fill($params);
        $cm->ip = request()->ip();
        if ($cm->save()) {
            $this->makeResponse();
            $this->done = true;
        }
    }

    private function makeResponse()
    {
        $this->resp = [
            'status' => 'ok',
            'text' => 'post_added_successfully',
            'message' => 'پست با موفقیت افزوده شد.',
            'data' => null,
        ];
    }

    private function translateParams($params)
    {
        $res = [];
        foreach ($params as $key => $value) {
            $key = str_replace('comment_', '', $key);
            $res[$key] = $value;
        }
        return $res;
    }

    private function validator()
    {
        $this->validator = Validator::make(request()->all(), [
            'comment_name' => [
                'required',
                'min:3',
                'max:30',
                new validAlpha(),
            ],
            'parent_id' => [
                'nullable',
                'integer',
            ],
            'post_id' => [
                'required',
                'integer',
            ],
            'comment_content' => [
                'required',
                'min:5',
                'max:500',
                new validString,
            ],
            'comment_email' => [
                'nullable',
                'email',
            ],
        ]);

        if (!$this->validator->fails()) {
            $this->params = $this->validator->validated();
        }
    }
}
