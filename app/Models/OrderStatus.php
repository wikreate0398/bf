<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
	public $timestamps = false;

	protected $table = 'order_status';

	protected $fillable = [
        'name_ru',
        'name_ro',
        'name_en',
        'message_ru',
        'message_ro',
        'message_en',
    ];
}
