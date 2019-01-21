<?php

namespace App\Models\Auctions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auctions extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'auctions';

    protected $casts = [
        'bid_limit_people' => 'integer',
        'quantity'         => 'integer',
        'bid_limit_date'   => 'date'
    ];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code',
        'auction_type',
        'product_type',
        'retail_price',
        'bid_limit_date',
        'bid_limit_people',
        'quantity',
        'name_ru',
        'name_ro',
        'name_en',
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
}
