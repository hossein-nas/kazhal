<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'content', 'published', 'post_type', 'user_id', 'thumbnail_id',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'created_at_ts',
        'path',
    ];

    /**
     * @var array
     */
    protected $with = [
        'thumb',
        'author',
        'categories',
        // 'comments',
    ];

    /**
     * @return mixed
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'post_category');
    }

    /**
     * @return mixed
     */
    public function thumb()
    {
        return $this->hasOne('App\File', 'id', 'thumbnail_id');
    }

    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id', 'id');
    }

    /**
     * @return mixed
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getCreatedAtTsAttribute()
    {
        return $this->created_at->timestamp;
    }

    /**
     * @param $cats
     */
    public function syncCategories($cats)
    {
        $this->categories()->sync($cats);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function path()
    {
        return "/posts/{$this->slug}/show";
    }

    /**
     * @return mixed
     */
    public function getPathAttribute()
    {
        return $this->path();
    }
}
