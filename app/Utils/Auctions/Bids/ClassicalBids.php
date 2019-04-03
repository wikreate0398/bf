<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.03.2019
 * Time: 14:45
 */

namespace App\Utils\Auctions\Bids;


class ClassicalBids
{
    private $bidItems;

    public function __construct($bidItems)
    {
        $this->bidItems = $bidItems;
    }

    public function get()
    {
        $max = max($this->bidItems->prices());

        $maxBid = $this->bidItems->bids()->filter(function ($item) use($max){
            return ($max == $item->price) ? true : false;
        });

        if($maxBid->count() > 0)
        {
            return  $maxBid->first();
        }
    }
}