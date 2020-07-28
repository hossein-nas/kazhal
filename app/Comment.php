<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'name',
        'ip',
        'body',
        'email',
        'parent_id',
        'post_id',
        'verified',
    ];

    protected $with = [
        'post',
        'parent',
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function parent()
    {
        return $this->belongsTo('App\Comment', 'parent_id');
    }
    
}
