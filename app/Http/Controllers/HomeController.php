<?php

namespace App\Http\Controllers;

use App\Models\Evouchers;
use App\Models\Testimonials;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $data = [
            'evouchers'    => Evouchers::orderByRaw('page_up asc, id desc')->where('view', 1)->get(),
            'testimonials' => Testimonials::orderByRaw('page_up asc, id desc')->where('view', 1)->get(),
            'discounts'    => Order::where('id_status', 2) 
                                   ->orderByRaw('retail_price desc, price asc')
                                   ->with('auction')
                                   ->limit(2)
                                   ->get()  
        ]; 
 
        return view('public/home', $data);
    }

    public function page()
    {
        $data = \Pages::pageData();
        if(!$data) abort('404');
        return view('public/page', [
            'data'   => $data,
            'banner' => (new \Banner)->type('page')->page($data->id)->get()  
        ]);
    }

    public function test()
    {
        return view('public/test', []);
    }
}