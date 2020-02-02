<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'title','name','hashname','ext','basedir','base_url','is_responsive','specs','desc','keywords'
    ];
    protected $casts =[
        'specs' => 'json',
    ];
}
