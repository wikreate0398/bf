<?php

namespace App\Http\Controllers;
 
use App\Models\Order;
use App\Models\Auctions\Bids;
use Excel;

class ResultsController
{
    public function index()
    {
        $data = [
            'orders' => Order::lastDays()->orderStage()->where('id_status', 2)->paginate(15)
        ]; 

        return view('public/results.list', $data);
    } 

    public function bids($lang, $id_order)
    {
        $order = Order::lastDays()->orderStage()->where('id_status', 2)->findOrFail($id_order);
        $bids  = Bids::where('prepare_id', $order->bid_prepare_id)->withTrashed()->get(); 

        return Excel::download(
            new \App\Exports\BidsExport($order, $bids), 
            'licitation_' . $order->created_at->format('d_m_y_H_i') . '.xlsx'
        ); 
    }
}