<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;  
use App\Models\User;  
use App\Models\Transactions\Transactions;
use App\Models\Auctions\Bids;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{ 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public function dailyReports()
    { 

        $newAccounts = DB::table('users')
                         ->select('created_at', DB::raw('COUNT(id) as total'))
                         ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')")) 
                         ->get()
                         ->keyBy(function($v){
                            return \Carbon\Carbon::parse($v->created_at)->format('d.m.Y');
                         });

        $ordersStatistics = DB::table('order')
                              ->select('order.created_at' ,
                                 
                                DB::raw('SUM(order.qty) as totalQty'),  
                                DB::raw('SUM(order.price) as totalPrice'), 
                                DB::raw('SUM(auctions.retail_price) as totalRetailPrice')
                                )
                              ->leftJoin('auctions', 'auctions.id', '=', 'order.id_auction')
                              ->where('id_status', 2)
                              ->groupBy(DB::raw("DATE_FORMAT(order.created_at, '%Y-%m-%d')")) 
                              ->get()
                              ->keyBy(function($v){
                                return \Carbon\Carbon::parse($v->created_at)->format('d.m.Y');
                             });

        $orderRefunds = DB::table('order')
                              ->select('order.created_at' , 
                                DB::raw('COUNT(order.id) as totalRefunds'),
                                DB::raw('SUM(order.price) as totalPriceRefunds') 
                                ) 
                              ->where('id_status', 3)
                              ->groupBy(DB::raw("DATE_FORMAT(order.created_at, '%Y-%m-%d')")) 
                              ->get()
                              ->keyBy(function($v){
                                return \Carbon\Carbon::parse($v->created_at)->format('d.m.Y');
                             });

        $bidstStatistics = DB::table('bids')
                              ->select('bids.created_at', DB::raw('COUNT(bids.id) as total'), DB::raw('SUM(bids.bid_cost) as totalCost'))
                              ->groupBy(DB::raw("DATE_FORMAT(bids.created_at, '%Y-%m-%d')")) 
                              ->get()
                              ->keyBy(function($v){
                                return \Carbon\Carbon::parse($v->created_at)->format('d.m.Y');
                             });

        $eWallet = DB::table('users')
                     ->select('users.created_at', DB::raw('SUM(users.ballance) as totalBallance'))
                     ->groupBy(DB::raw("DATE_FORMAT(users.created_at, '%Y-%m-%d')")) 
                     ->get()
                     ->keyBy(function($v){
                        return \Carbon\Carbon::parse($v->created_at)->format('d.m.Y');
                     });

        $dates = collect($newAccounts->keys())->merge($ordersStatistics->keys())
                                                ->merge($orderRefunds->keys())
                                                ->merge($bidstStatistics->keys())
                                                ->merge($eWallet->keys())
                                                ->sort(function($a, $b){ 
                                                  return strtotime($b) - strtotime($a);
                                                })->unique();
         
        if (request()->filter) 
        {
          $from = request()->from;
          $to   = request()->to;
          $dates = $dates->filter(function($date) use($from, $to){
            if (strtotime($date) >= strtotime($from) && strtotime($date) <= strtotime($to)) {
              return true;
            }
            return false;
          });
        }

        return view('admin.statistics.daily-reports', 
                    compact('dates', 'newAccounts', 'ordersStatistics', 'orderRefunds', 'bidstStatistics', 'eWallet'));
    }   

    public function clientHistory($data = [])
    {

      if (request()->registry_type) 
      {
        switch (request()->registry_type) {
          case 'checkout':
              $order        = Order::orderStage()->filter()->get();
              $data['view'] = view('admin.statistics.client_history.checkout', ['data' => $order]);
            break;

          case 'wallet':
              $wallet       = Transactions::filter()->orderBy('id', 'desc')->paginate(30);  
              $data['view'] = view('admin.statistics.client_history.wallet', ['data' => $wallet]);
            break;

          case 'bids':
              $bids         = Bids::filter()->orderBy('id', 'desc')->withTrashed()->paginate(30);
              $data['view'] = view('admin.statistics.client_history.bids', ['data' => $bids]);
            break;
          
          default:
            # code...
            break;
        }
      }

      return view('admin.statistics.client-history', $data);
    }
}
