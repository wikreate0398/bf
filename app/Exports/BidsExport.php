<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BidsExport implements FromView, ShouldAutoSize
{ 
	protected $order, $bids;

	public function __construct($order, $bids)
	{
		$this->order = $order;
		$this->bids  = $bids;
	}

    public function view(): View
    {
        return view('exports.bids', [
            'order' => $this->order,
            'bids'  => $this->bids
        ]);
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'A1:E1' => NumberFormat::FORMAT_DATE_DDMMYYYY,
    //         'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
    //     ];
    // }
}