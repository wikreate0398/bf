<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auctions\Auctions;
use App\Models\Order;
use App\Models\User;
use App\Models\Auctions\Bids;
use App\Notifications\NewItemInCart;

class AddToCart extends Command
{
    protected $auction, $winnerBid, $prepareId;

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

    public function __construct($auction, $winnerBid, $prepareId = null)
    {
        parent::__construct(); 

        $this->auction   = $auction;   
        $this->winnerBid = $winnerBid;
        $this->prepareId = $prepareId;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $order = Order::create([
            'id_user'         => $this->winnerBid->id_user,
            'id_auction'      => $this->auction->id,
            'price'           => $this->winnerBid->price,
            'retail_price'    => $this->auction->retail_price,
            'bid_prepare_id'  => $this->getPrepareId(),
            'rand'            => generate_id() 
        ]);

        Bids::where('id_auction', $this->auction->id)->where('prepare_id', '0')->update(['prepare_id' => $this->getPrepareId()]);

        $user = User::whereId($this->winnerBid->id_user)->first();
        $user->notify(new NewItemInCart($this->auction));
        return $order->id;
    }   

    private function getPrepareId()
    {
        if(!$this->prepareId)
        {
            $this->prepareId = generate_id();
        }
        return $this->prepareId;
    }
}
