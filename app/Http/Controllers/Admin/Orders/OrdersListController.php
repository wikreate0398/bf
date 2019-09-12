<?php

namespace App\Http\Controllers\Admin\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order; 
use App\Models\OrderStatus; 
use App\Models\User; 
use App\Notifications\ChangedOrderStatus;
use App\Utils\Ballance;

class OrdersListController extends Controller
{

    private $method = 'orders/orders-list';

    private $folder = 'orders.orders_list'; 

    private $redirectRoute = 'admin_orders_list'; 

    private $input;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->model  = new Order;
        $this->method = config('admin.path') . '/' . $this->method;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {  
        $data = [
            'data'    => $this->model->orderStage()->filter()->get(),
            'table'   => $this->model->getTable(),
            'method'  => $this->method,
            'status'  => OrderStatus::orderByRaw('page_up asc, id desc')->get(),
            'clients' => User::has('order')->orderBy('id', 'desc')->get()
        ]; 

        Order::where('open', '1')->update(['open' => 0]);

        return view('admin.'.$this->folder.'.list', $data);
    }   

    public function changeStatus($id, Request $request, $returnData = [])
    { 
        $order            = Order::whereId($id)->firstOrFail(); 
        $order->id_status = $request->value;
        $order->save();
        if ($request->value == 3) // if refund
        {
            $order->refund_at = date('Y-m-d H:i:s');
            $order->save();
 
            (new Ballance($order->user))
                ->transactionType('refund_payment')
                ->setPrice($order->price)
                ->setProductCode($order->auction->code)
                ->setOrderId($order->id)
                ->replenish();

            $returnData = ['refund_at' => $order->refund_at->format('d.m.Y H:i'), 'class' => $order->status->class];
        }

        if (in_array($request->value, [3, 4])) {
            \Bus::dispatch(
                new \App\Console\Commands\CancelCartItem($order)
            );
        }

        $order->user->notify(new ChangedOrderStatus($order)); 

        return $returnData;
    } 
}
