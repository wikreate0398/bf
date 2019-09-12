<?php

namespace App\Console\Commands\Cron;
 
use Illuminate\Console\Command; 
use App\Models\Order;
use App\Notifications\ChangedOrderStatus;

class CartCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart';

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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        foreach (Order::where('in_cart', '1')->get() as $cart) 
        {
            if($cart->created_at->addHours(48) <= \Carbon\Carbon::now())
            {  
                \Bus::dispatch(
                    new \App\Console\Commands\CancelCartItem($cart)
                );
                $cart->id_status = 4;
                $cart->in_cart   = 0;
                $cart->save();
                $cart->user->notify(new ChangedOrderStatus($cart));
            }
        }  
    }
}
