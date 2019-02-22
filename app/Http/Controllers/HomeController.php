<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 21.01.2019
 * Time: 16:09
 */

namespace App\Http\Controllers;

use App\Models\Evouchers;
use App\Models\Testimonials;

class HomeController
{
    public function index()
    {
        $data = [
            'evouchers'    => Evouchers::orderByRaw('page_up asc, id desc')->where('view', 1)->get(),
            'testimonials' => Testimonials::orderByRaw('page_up asc, id desc')->where('view', 1)->get(),
        ];
        return view('public/home', $data);
    }

    public function page()
    {
        $data = \Pages::pageData();
        if(!$data) abort('404');
        return view('public/page', ['data' => $data]);
    }
}