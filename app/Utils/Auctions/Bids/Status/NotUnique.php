<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.03.2019
 * Time: 10:59
 */

namespace App\Utils\Auctions\Bids\Status;

class NotUnique implements BidStatusInterface
{
    const STATUS = '1';

    private $bids = null;

    public function __construct($bidItems, $uniqueSmall)
    {
        $array          = $bidItems->prices();
        $duplicatesBids = $this->_duplicates($array);

//        if (($key = array_search($uniqueSmall->price, $duplicatesBids)) !== false) {
//            unset($duplicatesBids[$key]);
//        }

        $this->bids = $bidItems->bids()->filter(function($bid) use($duplicatesBids){
            return in_array($bid->price, $duplicatesBids) ? true : false;
        });
    }

    private function _duplicates($array)
    {
        return array_unique(array_diff_assoc($array, array_unique($array)));
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