<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'order';

    protected $fillable = [
        'id_user', 'id_auction', 'price', 'in_cart', 'bid_prepare_id'
    ];

    protected $casts = [
        'id_user'    => 'integer',
        'id_auction' => 'integer',
        'in_cart'    => 'integer',
        'price'      => 'float',
        'bid_prepare_id' => 'integer'
    ];

    public function auction()
    {
        return $this->hasOne('App\Models\Auctions\Auctions', 'id', 'id_auction');
    }
}
