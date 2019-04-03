<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.03.2019
 * Time: 11:20
 */

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Utils\Paginate\PaginateList;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('cart')->except('empty_cart');
    }

    public function empty_cart()
    {
        return view('public.cart.empty');
    }

    public function view($url = false, PaginateList $paginateonList)
    {
        $cartItems       = Order::where('id_user', \Auth::user()->id)->where('in_cart', '1')->orderByRaw('id desc')->get();
        $pagination      = $paginateonList->addItems($cartItems);
        $currentCartItem = $pagination->current();

        if(!\Request::segment(4))
        {
            return redirect()->route('view_cart', ['lang' => lang(), 'url' => $currentCartItem->auction->url]);
        }

        $data = [
            'cart'         => $currentCartItem,
            'prev'         => $pagination->previous(),
            'next'         => $pagination->next(),
            'currentIndex' => $pagination->currentKey(),
            'totalItems'   => $pagination->count()
        ];

        return view('public.cart.view', $data);
    }

    public function delete($lang, $id)
    {
        $this->dispatch(
            new \App\Console\Commands\DeleteCartItem(
                Order::whereId($id)->where('in_cart', '1')->where('id_user', \Auth::user()->id)->firstOrFail()
            )
        );

        $this->dispatch(
            new \App\Console\Commands\DeleteCartItem(
                Order::whereId($id)->where('in_cart', '1')->where('id_user', \Auth::user()->id)->firstOrFail()
            )
        );
    }
}