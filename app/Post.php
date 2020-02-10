<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'published', 'post_type',
    ];


    public function thumb()
    {
        return $this->hasOne('App\File', 'id', 'thumbnail_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
