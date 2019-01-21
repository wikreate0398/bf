<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
	public $timestamps = false;

	protected $table = 'slider';

	protected $fillable = [
        'name_ru',
        'name_ro',
        'name_en',
        'description_ru',
        'description_ro',
        'description_en',
        'image' 
    ];
}
