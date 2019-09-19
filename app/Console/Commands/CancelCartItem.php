<?php

namespace App\Console\Commands;

use App\Models\Auctions\Bids;
use App\Models\Auctions\Auctions;
use App\Models\Order;
use Illuminate\Console\Command;
use App\Utils\Ballance;
use App\Models\User;
use App\Notifications\ReturnBidCost;

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
        $getBids = Bids::where('prepare_id', $this->cart->bid_prepare_id)->withTrashed()->get()->groupBy('id_user');

        foreach ($getBids as $idUser => $userBids) {
            $user   = User::whereId($idUser)->withTrashed()->first(); 
            $amount = $userBids->sum('bid_cost');
            (new Ballance($user))
                ->transactionType('return_bid')
                ->setPrice($amount)
                ->setProductCode($this->cart->auction->code)
                ->setOrderId($this->cart->id)
                ->replenish(); 

            $user->notify(new ReturnBidCost($this->cart, $this->cart->auction, $amount));
        } 
    }
}
