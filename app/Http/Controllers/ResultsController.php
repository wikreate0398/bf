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

        $excel = \App::make('excel');
        return Excel::create('licitation_' . $order->created_at->format('d_m_y_H_i'), function($excel) use($order, $bids, $lang) {

            $excel->getDefaultStyle()
                ->getAlignment()
                ->applyFromArray(array(
                    'horizontal'    => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'      => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'      => TRUE
                ));

            $excel->sheet(\Constant::get('BIDS'), function($sheet) use($order, $bids, $lang) {
                $sheet->setColumnFormat(array( 
                    'D' => '0.00' 
                ));

                $rowCount = 0;
                $discountPrNum = [];
 
                $sheet->appendRow([
                    \Constant::get('CREATED_DATE'),
                    \Constant::get('ITEM'),
                    \Constant::get('AUCTION_CODE'),
                    \Constant::get('REG_BID'),
                    \Constant::get('PAYMENT_METHOD'), 
                ]);

                $rowCount++; 

                foreach ($bids as $bid) { 
                    $sheet->appendRow([
                        $bid->created_at->format('d.m.Y H:i'),
                        $order->auction["name_$lang"] . "\n" . $order->auction["name2_$lang"],
                        $order->auction->code,
                        $bid->price,
                        \Constant::get('ELECTRONIC_WALLET') 
                    ]);  
                    $rowCount++; 
                } 
 
                $sheet->cells("A1:E1", function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setBackground('#D8D8D8');
                }); 
            });
        })->download(); 
    }
}