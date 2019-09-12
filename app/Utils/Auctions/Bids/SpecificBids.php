<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.03.2019
 * Time: 14:45
 */

namespace App\Utils\Auctions\Bids;

use App\Utils\Auctions\Bids\Status\BidStatusInterface;
use Illuminate\Database\Eloquent\Collection;

use App\Utils\Auctions\Bids\Status\UniqueSmall;
use App\Utils\Auctions\Bids\Status\NotUnique;
use App\Utils\Auctions\Bids\Status\UniqueButNotSmall;

class SpecificBids implements BidTypesInterface
{
    private $bidItems;

    private $type = 'unique_small';

    private $uniqueBid;

    public function __construct($bidItems)
    {
        $this->bidItems = $bidItems;
    }

    private function getBids(BidStatusInterface $bid)
    {
        return Collection::make([
            'bids'   => $bid->get(),
            'status' => $bid->status()
        ]);
    }

    public function _bindType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function get()
    {
        if(!$this->uniqueBid)
        {
            $this->uniqueBid = $this->getBids(new UniqueSmall($this->bidItems));
        }

        switch ($this->type)
        {
            case 'unique_small':
                return $this->uniqueBid;
                break;

            case 'unique_but_not_small':
                return $this->getBids(new UniqueButNotSmall($this->bidItems, $this->uniqueBid['bids']));
                break;

            case 'not_unique':
                return $this->getBids(new NotUnique($this->bidItems, $this->uniqueBid['bids']));
                break;
        }
    }
}