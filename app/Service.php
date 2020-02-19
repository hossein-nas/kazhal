<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	protected $fillable = [
		'title', 'slug', 'content', 'excerpt', 'parent_id', 'thumbnail_id',
		'color_id', 'features', 'hardware', 'extra', 'service_type', 'price'
	];

	protected $casts = [
		'features'	=> 'json',
		'hardware'	=> 'json',
		'extra'		=> 'json'
	];

	public function thumbnail()
	{
		return $this->belongsTo('App\File', 'thumbnail_id', 'id');
	}

	public function color()
	{
		return $this->belongsTo('App\Color', 'color_id', 'id');
	}
}
