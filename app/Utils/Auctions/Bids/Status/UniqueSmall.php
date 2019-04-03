<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.03.2019
 * Time: 10:40
 */

namespace App\Utils\Auctions\Bids\Status;

use App\Utils\Auctions\Bids\SpecificBids;

class UniqueSmall extends SpecificBids implements BidStatusInterface
{
    const STATUS = '3';

    private $bids = null;

    public function __construct($bidItems)
    {
        $min = min($bidItems->prices());

        $minBid = $bidItems->bids()->filter(function ($item) use($min){
            return ($min == $item->price) ? true : false;
        });

        if($minBid->count() > 0)
        {
            $this->bids = $minBid->first();
        }
    }

    /**
     * @return collection of single item
     */
    public function get()
    {
        return $this->bids;
    }

    /**
     * @return string
     */
    public function status()
    {
        return self::STATUS;
    }
}