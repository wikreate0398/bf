<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.03.2019
 * Time: 10:41
 */

namespace App\Utils\Auctions\Bids\Status;

use App\Utils\Auctions\Bids\BidItems;
use function foo\func;

class UniqueButNotSmall implements BidStatusInterface
{
    const STATUS = '2';

    private $bids = null;

    public function __construct($bidItems, $uniqueSmall)
    {
        $bidsPrices = $this->_unique($bidItems->prices());

        $min        = $uniqueSmall->price;
        $prices = array_filter($bidsPrices, function($val) use($min){
            return ($val != $min) ? true : false;
        });

        $this->bids = $bidItems->bids()->filter(function($bid) use($prices){
            return in_array($bid->price, $prices) ? true : false;
        });
    }

    public function _unique($array)
    {
        return array_diff($array, array_unique(array_diff_assoc($array,array_unique($array))));
    }

    /**
     * @return collection of many items
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