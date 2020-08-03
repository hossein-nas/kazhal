<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'id'         => $this->id,
            'firstname'  => $this->firstname,
            'lastname'   => $this->lastname,
            'email'      => $this->email,
            'bio'        => $this->bio,
            'photo'      => new File($this->thumb),
            'role'       => $this->role,
            'activated'  => $this->activated,
            'created_at' => $this->created_at,
            'ip'         => request()->ip(),
        ];
    }
}
