<?php

namespace App\Console\Commands;

use App\Models\Auctions\Bids;
use App\Models\Auctions\Auctions;
use App\Models\Order;
use Illuminate\Console\Command;
use App\Console\Commands\AddToCart; 
use App\Utils\Auctions\Bids\WinnerBid;

class CancelCartItem extends Command
{
    protected $cart;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel_ cart_item';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Order $cart)
    {
        parent::__construct(); 
        $this->cart = $cart;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    { 
        $getBid = Bids::where('prepare_id', $this->cart->bid_prepare_id)
                      ->where('id_user', $this->cart->id_user)
                      ->where('id_auction', $this->cart->id_auction) 
                      ->whereRaw('CAST(price as DECIMAL) = CAST('.$this->cart->price.' as DECIMAL)')
                      ->orderByRaw('id asc')
                      ->first();

        if ($getBid) {
            $getBid->delete();  
        } 

        if(Bids::where('prepare_id', $this->cart->bid_prepare_id)->where('id_auction', $this->cart->id_auction)->count())
        {    
            $winnerBid = (new WinnerBid($this->cart->auction, $this->cart->bids))->get();   
            \Bus::dispatch(new AddToCart($this->cart->auction, $winnerBid, $this->cart->bid_prepare_id));  
        }   
    }
}
