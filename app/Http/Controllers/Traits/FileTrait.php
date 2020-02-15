<?php

namespace App\Http\Controllers\Traits;

use Intervention\Image\ImageManagerStatic as Image;

trait FileTrait {

    /*
    * @return string
    */
    private function getSupportedImages()
    {
        return collect([
            'jpeg',
            'jpg',
            'png',
            'svg',
        ]);
    }

    private function getSupportedFiles()
    {
        return collect([
            'zip',
            'rar',
            'pdf',
        ]);
    }

    private function getCropFrames()
    {
        return collect([
            'large' => ['width' =>1080 , 'height' =>675],
            'medium' => ['width' =>480, 'height' =>300],
            'small' => ['width' =>240, 'height' =>150]
        ]);
    }

    private function isResizable($ext)
    {
        if ( $this->getResizableImages()->contains($ext)){
            return true;
        }
        return false;
    }

    public function getResizableImages()
    {
        return collect([
            'png', 'jpeg', 'jpg'
        ]);
    }

    public function generateImageDimension()
    {
        $tmp_file_relative_path = $this->resp['tmp_file_path']['filepath'];
        $tmp_file_full_path = $this->resp['tmp_file_path']['fullpath'];
        $image = Image::make($tmp_file_full_path);

        $height = $image->height();
        $width = $image->width();
        $ratio = ( (float) $width / $height);
        return [
            'height'    => $height,
            'width'    => $width,
            'ratio'    => $ratio
        ];
    }

    public function cropImage()
    {
        $cropFrame = $this->getCropFrames();

        $tmp_file_full_path = $this->resp['tmp_file_path']['fullpath'];
        $basedir = $this->resp['tmp_file_path']['basedir'];
        $image = Image::make($tmp_file_full_path);

        foreach( $cropFrame as $frameName => $frame ){
            $width = $frame['width'];
            $height = $frame['height'];
            $ratio = ( (float) $width / $height );
            $newName = $basedir . $this->hashname . "_h" . $height . "." . $this->resp['ext'];
            $image->resize($width, $height)->save($newName);
            $this->resp['specs'][] = [
                'size' => $frameName,
                'width' => $width,
                'height' => $height,
                'ratio' => $ratio,
                'filesize' => filesize($newName),
                'fullpath' => $newName,
            ];
        }
    }

    public function generateImageSpecs()
    {
        if( $this->resp['is_responsive'] ){
            $this->cropImage();
        }
        else{
            $this->resp['specs'] = [
                [
                    'size' => 'default',
                    'width' => 0,
                    'height' => 0,
                    'ratio' => 0,
                    'filesize' => filesize($this->resp['tmp_file_path']['fullpath']),
                    'fullpath' => $this->resp['tmp_file_path']['fullpath']
                ]
            ];
        }

    }

    public function moveTempFiles()
    {
        // moving specs temp location to actual location
        $files = $this->resp['specs'];
        foreach( $files as $in => $f ){
            $old_path = $f['fullpath'];
            $basedir = $this->resp['basedir'];
            $new_path = $basedir . "/" . $this->hashname . "_H" . $f['height'] . "." . $this->resp['ext'];
            rename($old_path, $new_path);
            $this->resp['specs'][$in]['fullpath'] = $new_path;
        }

        // this is for unlinking actual uploaded file
        $uploaded_file = $this->resp['tmp_file_path']['fullpath'];
        unlink($uploaded_file);
        // unseting 'tmp_file_path' index
        unset($this->resp['tmp_file_path']);
    }

    public function persistInDisk()
    {
        $this->generateImageSpecs();
        $this->moveTempFiles();
    }

    public function persistInDB()
    {
        $file = new \App\File();
        $file->fill($this->resp)->save();
    }

}