<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	protected $fillable = [
		'title', 'slug', 'content', 'excerpt', 'parent_id', 'thumbnail_id',
		'color_id', 'features', 'hardware', 'extra', 'service_type'
	];

	protected $casts = [
		'features'	=> 'json',
		'hardware'	=> 'json',
		'extra'		=> 'json'
	];
}
