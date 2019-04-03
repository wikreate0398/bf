<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.03.2019
 * Time: 12:16
 */

namespace App\Models\Auctions;

use Illuminate\Database\Eloquent\Model;

class BidStatus extends Model
{
    protected $table = 'bids_status';

    protected $fillable = [
        'name_ru', 'name_ro', 'name_en', 'color', 'class'
    ];
}