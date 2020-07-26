<?php

namespace App\Utilities;

use App\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class Filer
{
    protected $attributes;

    public function __construct($attributes)
    {
        $this->attributes = $attributes;

        $this->init();
    }

    public function optimize()
    {
        //
    }

    public function getResponse()
    {
        return [
            'status' => 'success',
            'text' => 'file_uploaded_successfully',
            'message' => 'فایل با موفقیت آپلود شد.',
            'data' => $this->getParams(),
        ];
    }

    public function crop()
    {
        $cropFrame = $this->getCropFrames();
        $image = Image::make($this->attributes['file']);

        foreach ($cropFrame as $frameName => $frame) {
            $width = $frame['width'];
            $height = $frame['height'];
            $ratio = ((float) $width / $height);

            $filename = $this->attributes['hashname'] . "_H" . $height . "." . $this->attributes['ext'];
            $fullpath = Storage::path('public/images/' . $filename);
            $relativepath = Storage::url('public/images/' . $filename);

            $image->resize($width, $height)->save($fullpath, 100, 'png');

            $this->attributes['specs'][] = [
                'size' => $frameName,
                'width' => $width,
                'height' => $height,
                'ratio' => $ratio,
                'filesize' => filesize($fullpath),
                'fullpath' => $fullpath,
                'relativepath' => $relativepath,
            ];
        }

        // this makes small dimenssion image goes first item
        // array_reverse($this->attributes['specs']);

        return $this;
    }

    public function init()
    {
        $this->attributes = array_merge($this->attributes, [
            'ext' => $ext = $this->attributes['file']->extension(),
            'hashname' => Str::uuid()->toString(),
            'is_responsive' => (int) $this->isResizable($ext),
            'keywords' => (request()->get('keywords')) ? implode(',', request()->input('keywords')) : null,
            'basedir' => storage_path('app/public/images/'),
            'base_url' => '/storage/images',
        ]);

        $this->tempDiskStore();
        $this->originalFileSpec();

        return $this;
    }

    protected function tempDiskStore()
    {
        $this->attributes['filename'] = $filename = $this->attributes['hashname'] . "." . $this->attributes['ext'];

        if ($this->attributes['file']) {
            $this->attributes['file']->storeAs('public/images', $filename);
        }
    }

    protected function originalFileSpec()
    {
        $filepath = 'public/images/' . $this->attributes['filename'];
        $file = Storage::get($filepath);
        $image = Image::make($file);

        $this->attributes['specs']['original'] = [
            'filesize' => Storage::size($filepath),
            'height' => $image->height(),
            'width' => $image->width(),
            'ratio' => ($image->width() * 1.0) / $image->height(),
            'fullpath' => Storage::path('public/images/' . $filepath),
            'relativepath' => Storage::url('public/images/' . $filepath),
        ];
    }

    public function persist()
    {
        $this->removeOriginalFile();
        $params = $this->getParams();

        DB::beginTransaction();
        try {
            $file = File::create($params->toArray());

            $this->pushIdToParams($file->id);

            DB::commit();
        } catch (\Excpetion $e) {
            DB::rollback();

            throw $e;
        }
    }

    protected function removeOriginalFile()
    {
        $original = $this->attributes['specs']['original'];

        Storage::delete('public/images/' . $this->attributes['filename']);

        unset($this->attributes['specs']['original']);

        // this makes specs array reverse
        $this->attributes['specs'] = array_reverse($this->attributes['specs']);
    }

    public function pushIdToParams($id)
    {
        $this->attributes['id'] = $id;
    }

    protected function getParams()
    {
        return collect($this->attributes)
            ->only([
                'id',
                'title',
                'name',
                'desc',
                'ext',
                'is_responsive',
                'hashname',
                'basedir',
                'base_url',
                'keywords',
                'specs',
            ]);
    }

    protected function getSupportedImages()
    {
        return collect([
            'jpeg',
            'jpg',
            'png',
            'svg',
        ]);
    }

    protected function getSupportedFiles()
    {
        return collect([
            'zip',
            'rar',
            'pdf',
        ]);
    }

    protected function getCropFrames()
    {
        $base_ratio = $this->attributes['specs']['original']['ratio'];
        $frames = collect([
            'large' => ['width' => 1080, 'height' => 1080 / $base_ratio],
            'medium' => ['width' => 480, 'height' => 480 / $base_ratio],
            'small' => ['width' => 240, 'height' => 240 / $base_ratio],
        ]);
        return $frames;
    }

    protected function isResizable($ext)
    {
        if ($this->getResizableImages()->contains($ext)) {
            return true;
        }
        return false;
    }

    protected function getResizableImages()
    {
        return collect([
            'png', 'jpeg', 'jpg',
        ]);
    }
}
