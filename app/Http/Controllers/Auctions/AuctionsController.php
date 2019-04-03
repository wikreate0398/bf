<?php

namespace App\Http\Controllers\Auctions;

use App\Http\Controllers\Controller;
use App\Models\Auctions\Auctions;
use App\Models\User;
use App\Utils\Auctions\AuctionState;
use App\Models\Auctions\Bids;
use App\Utils\Paginate\PaginateList;

class AuctionsController extends Controller
{
    public $auctions;

    public $auction;

    public $show_data = [];

    public $user;

    public static $auction_type;

    public function __construct() {}

    public function index()
    {
        $data = [
            'auctions' => Auctions::list()->sumTotalBids()->where('auction_type', self::$auction_type)->get()
        ];

        return view('public/auction/list', $data);
    }

    public function show($lang, $url, PaginateList $paginateonList)
    {
        $this->auctions = Auctions::list()->where('auction_type', self::$auction_type)->get();
        $this->auction  = Auctions::active()->sumTotalBids()->totalActiveBids()->where('url', $url)->firstOrFail();
        $this->user     = User::whereId(@\Auth::user()->id)->proposedBids($this->auction->id)->first();

        $pagination = $paginateonList->addItems($this->auctions)->addCurrentIndex($this->auction->id);

        $this->show_data = [
            'auctions'     => $this->auctions ,
            'auction'      => $this->auction,
            'prev'         => $pagination->previous(),
            'next'         => $pagination->next(),
            'currentIndex' => $pagination->currentKey(),
            'user'         => $this->user,
            'auctionState' => new AuctionState($this->auction, $this->user)
        ];

        if(\Auth::check() && $this->user->bids->count())
        {
            $this->add_show_data();
        }

        return view('public/auction/show', $this->show_data);
    }

    public function makeOrder(Auctions $auction)
    {
        if($auction->bids->count())
        {
            $specificOrderClass = new \App\Console\Commands\OrderTypes\SpecificOrder($auction);
            $this->dispatch($specificOrderClass);
            $auction->quantity--;
            $auction->save();
        }
    }
}