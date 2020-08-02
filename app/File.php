<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'name', 'hashname', 'ext', 'basedir', 'base_url', 'is_responsive', 'specs', 'desc', 'keywords',
    ];
    /**
     * @var array
     */
    protected $casts = [
        'specs' => 'json',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'src_set',
    ];

    /**
     * @return mixed
     */
    public function getSrcSetAttribute()
    {
        $images = $this->specs;

        return collect($images)
            ->map(function ($img) {
                return $img['relativepath'] . ' ' . $img['width'] . 'w';
            })
            ->reduce(function ($col, $item) {
                if ( ! $col) {
                    return $item;
                }

                return $col . ', ' . $item;
            });
    }

}
