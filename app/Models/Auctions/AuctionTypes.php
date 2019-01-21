<?php

namespace App\Models\Auctions;

use Illuminate\Database\Eloquent\Model;

class AuctionTypes extends Model
{
	public $timestamps = false;

	protected $table = 'auction_types';

	protected $fillable = [
        'name_ru',
        'name_ro',
        'name_en',
    ];
}
