<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class File extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'     => $this->title,
            'ext'       => $this->ext,
            'desc'      => $this->desc,
            'is_responsive' => $this->is_responsive,
            'keywords'  => $this->keywords,
            'specs'     => $this->specs,
        ];
    }
}
