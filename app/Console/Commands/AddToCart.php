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
    protected $auction, $winnerBid, $preparedId;

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

    public function __construct($auction, $winnerBid, $preparedId = null)
    {
        parent::__construct(); 

        $this->auction   = $auction;   
        $this->winnerBid = $winnerBid;
        $this->preparedId = $preparedId;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $prepareId = $this->preparedId ? $this->preparedId : $this->getneratePrepareId();
        $order = Order::create([
            'id_user'         => $this->winnerBid->id_user,
            'id_auction'      => $this->auction->id,
            'price'           => $this->winnerBid->price,
            'retail_price'    => $this->auction->retail_price,
            'bid_prepare_id'  => $prepareId,
            'rand'            => generate_id() 
        ]);

        if (!$this->preparedId) 
        {
            Bids::where('id_auction', $this->auction->id)
            ->where('prepare_id', '0')
            ->update(['prepare_id' => $prepareId]);
        } 
        
        $user = User::whereId($this->winnerBid->id_user)->first();
        $user->notify(new NewItemInCart($this->auction));
        return $order->id;
    }   

    private function getneratePrepareId()
    { 
        return generate_id();
    }
}
