<?php

namespace App\Http\Controllers\File;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileTrait;
use App\Http\Requests\FileRequest;
use App\Utilities\Filer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FilesController extends Controller
{
    use FileTrait;

    protected $hashname = null;

    protected $resp = [];

    public function store(FileRequest $request)
    {
        $filer = new Filer($request->all());
            $filer->persist();

        if ($request->expectsJson()) {
            return response()->json($filer->getResponse());
        }

        return response($filer->getResponse(), 200);
    }

    public function index(Request $req)
    {
        if (!$validate = $this->validateParams($req->all())) {
            return response()->json($this->res);
        }

        try {
            $this->initAttributes();
            $this->persistInDisk();
            $file_info = $this->persistInDB();
        } catch (\Exception $e) {
            dd('error happened');
        }

        return response()->json([
            'status'  => 'ok',
            'message' => 'file_uploaded_successfuly',
            'message' => 'بهمث با موفقیت آپلود شد',
            'data'    => $file_info,
        ]);
    }

    public function initAttributes()
    {
        $this->hashname              = $hashname              = Str::uuid()->toString();
        $ext                         = $this->resp['file']->extension();
        $this->resp['hashname']      = $this->hashname;
        $this->resp['ext']           = $ext;
        $this->resp['basedir']       = storage_path('app/public/images');
        $this->resp['is_responsive'] = (int) $this->isResizable($this->resp['ext']);
        $this->resp['base_url']      = '/storage/images';
        if (isset($this->resp['keywords'])) {
            $this->resp['keywords'] = implode(',', $this->resp['keywords']);
        }

        if (request()->hasFile('file')) {
            $tmp_path                    = "/temp/images/${hashname}.${ext}";
            $this->resp['tmp_file_path'] = [
                'basedir'  => storage_path('app' . "/temp/images/"),
                'filepath' => $tmp_path,
                'fullpath' => storage_path('app' . $tmp_path),
            ];
            request()->file('file')->storeAs('temp/images', "${hashname}.${ext}");
        }

        return 'done';
    }

    public function validateParams($params)
    {
        $validate = Validator::make($params, [
            'file'     => 'required|file|mimes:png,jpg,jpeg,svg|max:4096',
            'title'    => 'required|regex:/^[^\_\:\#\$]+$/i|min:10',
            'desc'     => 'required|regex:/^[^\_\:\#\$]+$/i|min:10',
            'name'     => 'required|regex:/^[\w\d\_\(\)]+\.[\w]*$/i',
            'keywords' => 'nullable|array',
        ]);

        if ($validate->fails()) {
            $this->res = [
                'status'  => 'error',
                'message' => 'there_is_an_error_in_file_upload',
                'text'    => 'خطایی در آپلود فایل رخ داد.',
                'data'    => $validate->errors(),
            ];

            return false;
        }

        $this->resp = $validate->validated();
        return true;
    }
}
