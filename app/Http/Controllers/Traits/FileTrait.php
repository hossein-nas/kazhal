<?php

namespace App\Http\Controllers\Traits;

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

}