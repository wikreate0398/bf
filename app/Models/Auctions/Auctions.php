<?php

namespace App\Models\Auctions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auctions extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'auctions';

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $fillable = [
        'code',
        'auction_type',
        'product_type',
        'retail_price',
        'personal_bid_limit',
        'total_bid_limit',
        'quantity',
        'name_ru',
        'name_ro',
        'name_en',
        'name2_ru',
        'name2_ro',
        'name2_en',
        'description_ru',
        'description_ro',
        'description_en',
        'url',
        'image',
        'seo_title_ru',
        'seo_title_ro',
        'seo_title_en',
        'seo_description_ru',
        'seo_description_ro',
        'seo_description_en',
        'seo_keywords_ru',
        'seo_keywords_ro',
        'seo_keywords_en',
    ];

    protected $casts = [
        'personal_bid_limit' => 'integer',
        'quantity'           => 'integer',
        'total_bid_limit'    => 'integer'
    ];

    public function scopeList($query)
    {
        return $query->select('auctions.*')->orderByRaw('auctions.page_up asc, auctions.id desc')->active();
    }

    public function scopeActive($query)
    {
        return $query->where('view', 1);
    }

    public function bids()
    {
        return $this->hasMany('App\Models\Auctions\Bids', 'id_auction', 'id')->has('user');
    }

    public function scopeSumTotalBids($query)
    {
        $query->withCount(['bids' => function($query){
            return $query->where('prepare_id', 0);
        }]);
    }

    public function scopeTotalActiveBids($query)
    {
        return $query->with(['bids' => function($query){
            return $query->where('prepare_id', 0);
        }]);
    }
}
