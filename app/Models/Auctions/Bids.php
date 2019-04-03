<?php

namespace App\Models\Auctions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bids extends Model
{
    use SoftDeletes;

    protected $table = 'bids';

    protected $fillable = [
        'id_user', 'id_auction', 'price', 'prepare_id'
    ];

    protected $casts = [
        'id_user'    => 'integer',
        'id_auction' => 'integer',
        'prepare_id' => 'integer',
        'price'      => 'float'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }
}
