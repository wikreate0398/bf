<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'order';

    protected $fillable = [
        'id_user', 
        'id_auction', 
        'id_provider', 
        'id_status', 
        'price', 
        'retail_price',
        'in_cart', 
        'bid_prepare_id', 
        'rand', 
        'name', 
        'surname', 
        'phone', 
        'payment_type', 
        'qty', 
        'open',
        'refund_at', 
        'lang',
        'ordered_at'
    ];

    protected $casts = [
        'id_user'        => 'integer',
        'id_auction'     => 'integer',
        'in_cart'        => 'integer',
        'price'          => 'float',
        'bid_prepare_id' => 'integer',
        'id_status'      => 'integer',
        'qty'            => 'integer',
        'refund_at'      => 'datetime',
        'ordered_at'     => 'datetime',
        'open'           => 'integer'
    ];

    public function auction()
    {
        return $this->hasOne('App\Models\Auctions\Auctions', 'id', 'id_auction')->withTrashed();
    }

    public function bids()
    {
        return $this->hasMany('App\Models\Auctions\Bids', 'prepare_id', 'bid_prepare_id')->has('user');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user')->withTrashed();
    }

    public function provider_data()
    {
        return $this->hasOne('App\Models\Evouchers', 'id', 'id_provider');
    }

    public function status()
    {
        return $this->hasOne('App\Models\OrderStatus', 'id', 'id_status');
    }

    public function scopeLastDays($query, $days = 7)
    {
        return $query->where('in_cart', '0')->whereDate('ordered_at', '>=', \Carbon\Carbon::now()->subDays($days));
    }

    public function scopeCartStage($query)
    {
        return $query->where('in_cart', '1')
                     ->where('id_status', null)
                     ->where('created_at', '>=', \Carbon\Carbon::now()->addHours(-48))
                     ->orderByRaw('id desc');
    }

    public function scopeOrderStage($query)
    {
        return $query->where('in_cart', '0')->orderBy('ordered_at', 'desc');
    }

    public function scopeFilter($query)
    {
        if(request()->q)
        {
            $searchQuery = request()->q;
            $query->where('rand', 'like', '%'.$searchQuery.'%')
                  ->orWhere('phone', 'like', '%'.$searchQuery.'%')
                  ->orWhere('price', 'like', '%'.$searchQuery.'%')
                  ->orWhere(function($query) use($searchQuery){
                    return $query->whereHas('user', function($query) use($searchQuery){
                        $query->where('name', 'like', '%'.$searchQuery.'%')
                              ->orWhere('email', 'like', '%'.$searchQuery.'%')
                              ->orWhere('account_number', 'like', '%'.$searchQuery.'%');
                    });
                  }); 
        }

        if (request()->status) {
            $query->where('id_status', request()->status);
        }

        if (request()->client) {
            $query->where('id_user', request()->client);
        }

        if (request()->auction_type) {
            $auction_type = request()->auction_type;
            $query->whereHas('auction', function($query) use($auction_type){
                return $query->where('auction_type', $auction_type);
            });
        }  
 
        if (request()->from) { 
            $query->where('ordered_at', '>=', \Carbon\Carbon::parse(request()->from . ' 00:00:00')->format('Y-m-d H:i:s'));
        }

        if (request()->to) {
            $query->where('ordered_at', '<=', \Carbon\Carbon::parse(request()->to . ' 23:59:59')->format('Y-m-d H:i:s'));
        }

        return $query;
    } 
}
