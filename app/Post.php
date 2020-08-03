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
        'path',
    ];

    protected $with = [
        'thumb',
        'author',
        'categories',
        // 'comments',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'post_category');
    }

    public function thumb()
    {
        return $this->hasOne('App\File', 'id', 'thumbnail_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function path()
    {
        return config('app.url') . "posts/" . $this->slug . "/show/";
    }

    public function getCreatedAtTsAttribute()
    {
        return $this->created_at->timestamp;
    }

    public function syncCategories($cats)
    {
        $this->categories()->sync($cats);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPathAttribute()
    {
        return $this->path();
    }
}
