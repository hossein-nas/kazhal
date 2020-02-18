<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
	protected $fillable = [
		'primary_color', 'color_one', 'color_two', 'text_color', 'contrast_color', 'gradient'
	];
}
