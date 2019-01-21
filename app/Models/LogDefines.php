<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogDefines extends Model
{
	public $timestamps = false;

	protected $table = 'log_defines';

	protected $fillable = [
        'define',
        'log_name'
    ];
}
