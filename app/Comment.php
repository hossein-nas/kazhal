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

    protected $appends = [
        'local_time',
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

    public function getLocalTimeAttribute()
    {
        $date = \Morilog\Jalali\Jalalian::fromCarbon($this->created_at);
        if ($this->created_at->diffInDays(\Carbon\Carbon::now()) > 7) {
            return \Morilog\Jalali\CalendarUtils::convertNumbers($date->format('%A, %d %B %y - %H:%M'));
        }
        return \Morilog\Jalali\CalendarUtils::convertNumbers($date->ago());
    }
}
