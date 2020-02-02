<?php

namespace App\Http\Controllers\Traits;

trait FileTrait {
    protected $hey = "file";

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
            'pdf',
        ]);
    }

    private function getValidExt( $filePath ){

    }
}