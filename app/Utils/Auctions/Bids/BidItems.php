<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.03.2019
 * Time: 14:47
 */

namespace App\Utils\Auctions\Bids;


class BidItems
{
    private $bids;

    public function __construct($bids)
    {
        $bids->map(function ($item) use($bids){
            unset($item['created_at']);
            unset($item['updated_at']);
            unset($item['deleted_at']);
            unset($item['prepare_id']);
            unset($item['id_user']);
            unset($item['id_auction']);
        });

        $this->bids = $bids;
    }

    public function bids()
    {
        return $this->bids;
    }

    public function prices()
    {
        return $this->bids->pluck('price')->toArray();
    }
}