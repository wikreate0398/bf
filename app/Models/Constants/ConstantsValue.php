<?php

namespace App\Models\Constants;

use Illuminate\Database\Eloquent\Model;

class ConstantsValue extends Model
{
	public $timestamps = false;

	protected $table = 'constants_value';

	protected $fillable = [
        'id_lang',
        'id_const',
        'value'
    ];

	protected $casts = [
	    'id_lang'  => 'integer',
        'id_const' => 'integer',
    ];
}
