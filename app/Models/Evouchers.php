<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evouchers extends Model
{
	public $timestamps = false;

	protected $table = 'evouchers';

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
