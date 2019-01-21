<?php

namespace App\Models\Banner;

use Illuminate\Database\Eloquent\Model;

class BannerPages extends Model
{
	public $timestamps = false;

	protected $table = 'banner_pages';

	protected $fillable = [
        'id_banner',
        'type',
        'id_page'
    ];

	public function banner()
    {
        return $this->hasOne('App\Models\Banner\Banner', 'id', 'id_banner');
    }
}
