<?php

namespace App\Http\Controllers\Auctions;

use App\Models\Auctions\Auctions;
use App\Models\User;
use App\Models\Auctions\Bids;
use App\Models\Order;
use App\Models\Auctions\BidStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Auctions\AuctionState;
use App\Utils\Auctions\Bids\BidItems;
use App\Utils\Auctions\Bids\SpecificBids;
use App\Utils\Ballance; 

class SpecificAuctionController extends AuctionsController
{
    public function __construct()
    { 
        self::$auction_type = 'specific';
    }

    public function add_show_data()
    {
        $bidItems                                = new BidItems($this->auction->bids);
        $specificBids                            = new SpecificBids($bidItems);
        $this->show_data['uniqueBid']            = $specificBids->_bindType('unique_small')->get();
        $this->show_data['notUniqueBid']         = $specificBids->_bindType('not_unique')->get();
        $this->show_data['uniqueButNotSmallBid'] = $specificBids->_bindType('unique_but_not_small')->get();
        $this->show_data['bid_status']           = BidStatus::all()->keyBy('id');  
    }

    public function addBid($lang, $id, Request $request, $flashMessage = '')
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
            $order   = Order::whereId($idOrder)->first(); 
            if (@$order->id_user == Auth::user()->id) 
            {
                $redirect = route('view_cart', ['lang' => $lang, 'id' => $idOrder]);
            }
            else
            {
                $flashMessage = 'Вы оставили последнюю ставку однако победитель уже установлен.'; 
                if ($order->auction->quantity <= 0) 
                {
                    $specificAuctions = \Pages::pageData('specific-auctions');
                    $redirect         = setUri($specificAuctions['url']);
                }
            }
        }  

        return \JsonResponse::success(['messages' => \Constant::get('BID_ADDED'), 'redirect' => $redirect], $flashMessage);
    } 
}