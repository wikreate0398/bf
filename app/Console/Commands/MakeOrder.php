<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auctions\Auctions;
use App\Models\Order;
use App\Models\Auctions\Bids;
use App\Notifications\NewItemInCart;

abstract class MakeOrder extends Command
{
    protected $auction, $bids, $prepareId, $user;

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

    public function __construct(Auctions $auction)
    {
        parent::__construct();

        $this->auction = $auction;

        if(!$this->bids)
        {
            $this->bids = $auction->bids;
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Order::create([
            'id_user'         => $this->bid->id_user,
            'id_auction'      => $this->auction->id,
            'price'           => $this->bid->price,
            'bid_prepare_id'  => $this->getPrepareId()
        ]);

        Bids::where('id_auction', $this->auction->id)->update(['prepare_id' => $this->getPrepareId()]);

        $this->user->notify(new NewItemInCart($this->auction));
    }

    public function addBids($bids = false)
    {
        $this->bids = $bids;
        return $this;
    }

    public function setPrepareId($prepareId)
    {
        $this->prepareId = $prepareId;
        return $this;
    }

    protected function setUser($user)
    {
        $this->user = $user;
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
