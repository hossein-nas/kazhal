<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'conent' => $this->content,
            'slug' => $this->slug,
            'published' => $this->published,
            'author' => new User($this->author),
            'thumb' => new File($this->thumb),
            'type' => ($this->post_type == 1) ? 'news' : 'tuts',
        ];
    }
}
