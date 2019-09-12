<?php

namespace App\Http\Controllers\Auctions;

use App\Models\Auctions\Auctions;
use App\Models\User;
use App\Models\Order;
use App\Models\Auctions\Bids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Auctions\AuctionState;

use App\Utils\Auctions\Bids\BidItems;
use App\Utils\Auctions\Bids\SpecificBids;
use App\Utils\Ballance;
use App\Console\Commands\AddToCart;

class ClassicAuctionController extends AuctionsController
{
    public function __construct()
    {
        self::$auction_type = 'classical';
    }

    public function add_show_data() {}

    public function addBid($lang, $id, Request $request)
    {
        $user         = User::whereId(\Auth::user()->id)->proposedBids($id)->first();
        $auction      = Auctions::active()->whereId($id)->totalActiveBids()->firstOrFail();
        $auctionState = new AuctionState($auction, $user);

        if($auctionState->canMakeBids() !== true)
        {
            return \JsonResponse::error(['messages' => $auctionState->getErrorMessage()]);
        }

        if(!$request->integer && !$request->decimal)
        {
            return \JsonResponse::error(['messages' => \Constant::get('ENTER_AMOUNT')]);  
        }

        $price = toFloat($request->integer . '.' . $request->decimal);

        Bids::create([
            'id_user'    => Auth::user()->id,
            'id_auction' => $id,
            'price'      => $price,
            'bid_cost'   => setting('bid_price')
        ]); 

        (new Ballance($user))
            ->transactionType('bid_payment')
            ->setPrice(setting('bid_price'))
            ->setProductCode($auction->code)
            ->off();
    
        $redirect = setUri(\Request::segment(2) . '/' . $auction->url);
        if($auction->total_bid_limit == Bids::where('id_auction', $id)->where('prepare_id', '0')->count())
        { 
            $idOrder = $this->addToCart($auction->id); 
            $redirect = route('view_cart', ['lang' => $lang, 'id' => $idOrder]);
        }

        return \JsonResponse::success(['messages' => \Constant::get('BID_ADDED'), 'redirect' => $redirect]);
    }
}