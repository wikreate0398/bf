<?php

namespace App\Models\Auctions;

use Illuminate\Database\Eloquent\Model;

class ProductTypes extends Model
{
	public $timestamps = false;

	protected $table = 'product_types';

	protected $fillable = [
        'name_ru',
        'name_ro',
        'name_en',
    ];
}
