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
        'user_id',
        'post_id',
        'verified',
        'verified_by',
    ];

    protected $appends = [
        'local_time',
        'path',
    ];

    protected $with = [
        'post',
        'parent',
        'user',
        'verifier',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('verified', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->whereVerified('1');
        });

        static::addGlobalScope('latest', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->orderByDesc('created_at');
        });
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function verifier()
    {
        return $this->belongsTo("App\User", 'verified_by', 'id');
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

    public function verify()
    {
        $this->update(['verified' => 1, 'verified_by' => auth()->id()]);
    }

    public function unverify()
    {
        $this->update(['verified' => 0, 'verified_by' => null]);
    }

    public function path()
    {
        return $this->post->path . "#comment-no-" . $this->id;
    }

    public function getPathAttribute()
    {
        return $this->path();
    }
}
