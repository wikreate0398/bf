<?php

namespace App\Utils\Auctions\Bids;

use App\Models\Auctions\Bids;
 
class WinnerBid
{	 
	private $winnerBidId;

	function __construct($auction, $bids)
	{
		if($auction->auction_type == 'specific') {
			$this->winnerBidId = (new SpecificBids(new BidItems($bids)))->get()['bids']->id;
		} else {
			$this->winnerBidId =  (new ClassicalBids(new BidItems($bids)))->get()->id;
		}
	}

	public function get()
	{
		return Bids::whereId($this->winnerBidId)->first();
	}
}