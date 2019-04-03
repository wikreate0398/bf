<?php

namespace App\Console\Commands;

use App\Models\Auctions\Bids;
use App\Models\Order;
use Illuminate\Console\Command;

class DeleteCartItem extends Command
{
    protected $cart;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        Bids::where('prepared_id', $this->cart->bid_prepare_id)
            ->where('id_user', $this->cart->id_user)
            ->where('id_auction', $this->cart->id_auction)
            ->where('price', $this->cart->price)
            ->orderBy('id asc')
            ->delete();

        $this->cart->delete();
    }
}
