<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'published', 'post_type', 'user_id', 'thumbnail_id',
    ];

    protected $appends = [
        'created_at_ts',
    ];

    public function categories(){
        return $this->belongsToMany('App\Category', 'post_category');
    }

    public function thumb()
    {
        return $this->hasOne('App\File', 'id', 'thumbnail_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function getCreatedAtTsAttribute()
    {
        return $this->created_at->timestamp;
    }
}
