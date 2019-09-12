<?php

namespace App\Models\Auctions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bids extends Model
{
    use SoftDeletes;

    protected $table = 'bids';

    protected $fillable = [
        'id_user', 'id_auction', 'price', 'bid_cost', 'prepare_id'
    ];

    protected $casts = [
        'id_user'    => 'integer',
        'id_auction' => 'integer',
        'prepare_id' => 'integer',
        'price'      => 'float',
        'bid_cost'   => 'float'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }

    public function auction()
    {
        return $this->hasOne('App\Models\Auctions\Auctions', 'id', 'id_auction');
    } 
  
    public function scopeFilter($query)
    {
        if(request()->q)
        {
            $searchQuery = request()->q; 
            $query->whereHas('user', function($query) use($searchQuery){
                $query->where('email', 'like', '%'.$searchQuery.'%')
                      ->orWhere('account_number', 'like', '%'.$searchQuery.'%');
            });
        }

        if (request()->from) { 
            $query->where('created_at', '>=', \Carbon\Carbon::parse(request()->from . ' 00:00:00')->format('Y-m-d H:i:s'));
        }

        if (request()->to) {
            $query->where('created_at', '<=', \Carbon\Carbon::parse(request()->to . ' 23:59:59')->format('Y-m-d H:i:s'));
        }

        return $query;
    }
}
