<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	public $timestamps = false;

	protected $table = 'menu';

	protected $fillable = [
        'name_ru',
        'name_ro',
        'name_en',
        'text_ru',
        'text_ro',
        'text_en',
        'url',
        'seo_title_ru',
        'seo_title_ro',
        'seo_title_en',
        'seo_description_ru',
        'seo_description_ro',
        'seo_description_en',
        'seo_keywords_ru',
        'seo_keywords_ro',
        'seo_keywords_en'
    ];

//	public function banner_pages()
//    {
//        return $this->hasMany('App\Models\Banner\BannerPages', 'id_page', 'id')->where('type', 'page');
//    }
}
