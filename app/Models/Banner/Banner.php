<?php

namespace App\Models\Banner;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
	public $timestamps = false;

	protected $table = 'banners';

	protected $fillable = [
        'name',
        'link',
        'image_top',
        'image_side',
        'image_background'
    ];

    public function banner_pages()
    {
        return $this->hasMany('App\Models\Banner\BannerPages', 'id_banner', 'id');
    }
}
