<?php

namespace App\Console\Commands;

use App\Models\Auctions\Bids;
use App\Models\Auctions\Auctions;
use App\Models\Order;
use Illuminate\Console\Command;
use App\Console\Commands\AddToCart; 
use App\Utils\Auctions\Bids\WinnerBid;

class DeleteCartItem extends Command
{
    protected $cart;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete_cart_item';

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
        \Bus::dispatch(
            new \App\Console\Commands\CancelCartItem($this->cart)
        );
        $this->cart->delete();
    }
}
