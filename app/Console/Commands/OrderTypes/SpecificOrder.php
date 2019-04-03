<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2019
 * Time: 0:45
 */

namespace App\Console\Commands\OrderTypes;


use App\Console\Commands\MakeOrder;
use App\Models\Auctions\Auctions;
use App\Models\Auctions\Bids;
use App\Models\User;
use App\Utils\Auctions\Bids\BidItems;
use App\Utils\Auctions\Bids\SpecificBids;

class SpecificOrder extends MakeOrder implements OrderTypesInterface
{
    protected $specificBids;

    public function __construct(Auctions $auction)
    {
        parent::__construct($auction);

        $this->specificBids = new SpecificBids(new BidItems($this->bids));
        $this->getWinnerBid();
    }

    public function getWinnerBid()
    {
        $bidId     = $this->specificBids->_bindType('unique_small')->get()['bids']->id;
        $this->bid = Bids::whereId($bidId)->first();
        $this->setUser(User::whereId($this->bid->id_user)->first());
    }
}