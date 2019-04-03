<?php

namespace App\Http\Controllers\Auctions;

use App\Models\Auctions\Auctions;
use App\Models\User;
use App\Models\Auctions\Bids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Auctions\AuctionState;
use App\Models\Auctions\BidStatus;
use App\Utils\Auctions\Bids\BidItems;
use App\Utils\Auctions\Bids\SpecificBids;

class SpecificAuctionController extends AuctionsController
{
    public function __construct()
    {
        $auction = Auctions::whereId(3)->totalActiveBids()->first();
        $this->makeOrder($auction);

        self::$auction_type = 'specific';
    }

    public function add_show_data()
    {
        $bidItems                                = new BidItems($this->auction->bids);
        $specificBids                            = new SpecificBids($bidItems);
        $this->show_data['uniqueBid']            = $specificBids->_bindType('unique_small')->get();
        $this->show_data['notUniqueBid']         = $specificBids->_bindType('not_unique')->get();
        $this->show_data['uniqueButNotSmallBid'] = $specificBids->_bindType('unique_but_not_small')->get();
        $this->show_data['bid_status']           = BidStatus::all()->keyBy('id') ;
    }

    public function addBid($lang, $id, Request $request)
    {
        $user    = User::whereId(\Auth::user()->id)->proposedBids($id)->first();
        $auction = Auctions::active()->whereId($id)->totalActiveBids()->firstOrFail();
        $auctionState = new AuctionState($auction, $user);

        if($auctionState->canMakeBids() !== true)
        {
            return \JsonResponse::error(['messages' => $auctionState->getErrorMessage()]);
        }

        if(!$request->integer && !$request->decimal)
        {
            return \JsonResponse::error(['messages' => 'Введите сумму']);
        }

        $price = toFloat($request->integer . '.' . $request->decimal);

        Bids::create([
            'id_user'    => Auth::user()->id,
            'id_auction' => $id,
            'price'      => $price
        ]);

        if($auction->total_bid_limit == Bids::where('id_auction', $id)->count())
        {
            $this->makeOrder($auction);
        }

        return \JsonResponse::success(['messages' => 'Ставка успешно добавлена', 'reload' => true]);
    }
}