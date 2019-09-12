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
use App\Models\Evouchers;
use App\Utils\Paginate\PaginateList;
use Illuminate\Http\Request;
use App\Utils\Ballance;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('cart')->except(['empty_cart', 'success']);
    }

    public function empty_cart()
    { 
        if(Order::where('id_user', \Auth::user()->id)->cartStage()->count())
        {

            return redirect()->route('view_cart', ['lang' => lang()]);
        }

        return view('public.cart.empty');
    }

    public function view($lang, $id = false, PaginateList $paginateonList)
    {
        $cartItems = Order::where('id_user', \Auth::user()->id) 
                          ->cartStage()
                          ->get();

        $pagination      = $paginateonList->addItems($cartItems);
        $currentCartItem = $pagination->current($id); 

        if (empty($currentCartItem)) 
        {
            return redirect()->route('empty_cart', ['lang' => lang()]);
        } 

        if(!\Request::segment(4))
        {
            return redirect()->route('view_cart', ['lang' => lang(), 'id' => $currentCartItem->id]);
        } 

        $data = [
            'cart'         => $currentCartItem,
            'prev'         => $pagination->previous(),
            'next'         => $pagination->next(),
            'currentIndex' => $pagination->currentKey(),
            'totalItems'   => $pagination->count(),
            'providers'    => Evouchers::where('view', '1')->orderByRaw('page_up asc, id desc')->get()
        ];

        return view('public.cart.view', $data);
    }

    public function order($lang, $id, Request $request)
    {
        $order = Order::where('id_user', \Auth::user()->id)->where('in_cart', '1')->whereId($id)->first();

        if(!$order)
        {
            return \JsonResponse::error(['messages' => 'Server Error']);
        }

        if($order->auction->auction_type == 'specific')
        {
            if(!$request->name or !$request->surname or !$request->phone or !$request->payment_type)
            {
                return \JsonResponse::error(['messages' => \Constant::get('REQ_FIELDS')]);
            }

            $data = [
                'name'         => $request->name,
                'surname'      => $request->surname,
                'phone'        => $request->phone,
                'payment_type' => $request->payment_type,
                'in_cart'      => 0,
                'id_status'    => 1,
                'qty'          => 1,
                'lang'         => lang(),
                'ordered_at'   => date('Y-m-d H:i:s')
            ]; 
        }
        else
        {
            if(!$request->provider or !$request->phone or !$request->payment_type)
            {
                return \JsonResponse::error(['messages' => \Constant::get('REQ_FIELDS')]);
            }

            $data = [
                'id_provider'  => $request->provider, 
                'phone'        => $request->phone,
                'payment_type' => $request->payment_type,
                'in_cart'      => 0,
                'id_status'    => 1,
                'qty'          => 1,
                'lang'         => lang(),
                'ordered_at'   => date('Y-m-d H:i:s')
            ]; 
        }

        Order::whereId($id)->update($data);

        (new Ballance(\Auth::user()))
            ->transactionType('good_payment')
            ->setPrice($order->price)
            ->setProductCode($order->auction->code)
            ->off();

        return \JsonResponse::success(['redirect' => route('success_cart', ['lang' => lang(), 'id' => $id])]);
    }

    public function success($lang, $id)
    {
        Order::whereId($id)->firstOrFail();
        return view('public.cart.success', []);
    }

    public function delete($lang, $id)
    {
        $order = Order::whereId($id)->where('in_cart', '1')->where('id_user', \Auth::user()->id)->firstOrFail();
        $this->dispatch(
            new \App\Console\Commands\DeleteCartItem(
                $order
            )
        );   
        return redirect()->route('view_cart', ['lang' => $lang]);
    }
}