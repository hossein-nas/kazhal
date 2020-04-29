<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = [
		'name',
		'ip',
		'content',
		'email',
		'parent_id',
		'post_id',
	];
}
