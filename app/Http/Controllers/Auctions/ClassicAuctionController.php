<?php

namespace App\Http\Controllers\Auctions;

use App\Models\Auctions\Auctions;
use App\Models\User;
use App\Models\Auctions\Bids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Auctions\AuctionState;

use App\Utils\Auctions\Bids\BidItems;
use App\Utils\Auctions\Bids\SpecificBids;

class ClassicAuctionController extends AuctionsController
{
    public function __construct()
    {
        self::$auction_type = 'classical';
    }

    public function add_show_data() {}

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

        return \JsonResponse::success(['messages' => 'Ставка успешно добавлена', 'reload' => true]);
    }
}