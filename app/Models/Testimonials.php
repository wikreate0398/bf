<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{
    public $timestamps = false;

    protected $table = 'testimonials';

    protected $fillable = [
        'name_ru',
        'name_ro',
        'name_en',
        'short_ru',
        'short_ro',
        'short_en',
        'review_ru',
        'review_ro',
        'review_en',
        'image',
        'video'
    ];
}
