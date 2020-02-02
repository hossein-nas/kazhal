<?php

namespace App\Http\Controllers\File;

use App\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    use FileTrait;
    protected $res = [];

    public function index(Request $req){

        if($req->ajax() && !$validate = $this->validateParmas($req->all())){
            return response()->json($this->res);
        }
        return 'uploaded';
    }

    public function ajaxUpload(){

    }

    public function validateParams($params)
    {
        $validate = Validator::make($params, [
            'file'          => 'required|file|mimes:jpeg,png,svg,pdf,zip|max:4096',
            'title'         => 'required|alpha_num|min:10',
            'desc'          => 'required|alpha_num|min:10',
            'name'          => 'required|alpha_num',
            'keywords'      => 'nullable|array',
        ]);
        
        if( $validate->fails()){
            $this->res = [
                'status' => 'error',
                'message' => 'there_is_an_error_in_file_upload',
                'text' => 'خطایی در آپلود فایل رخ داد.',
                'data' => null
            ];
            return false;
        }
        return true;
    }

}
