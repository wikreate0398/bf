<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25.05.2019
 * Time: 22:16
 */

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    public $timestamps = true;

    protected $table = 'transactions';

    protected $fillable = [
        'id_user',
        'transaction_type',
        'type',
        'price',
        'product_code',
        'ballance',
        'order_id'
    ];

    public function type_data()
    {
        return $this->hasOne('App\Models\Transactions\TransactionTypes', 'var', 'transaction_type');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
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