<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.03.2019
 * Time: 8:06
 */

namespace App\Utils\Auctions;

class AuctionState
{
    private $auction;

    private $user = null;

    public function __construct($auction, $user)
    {
        $this->auction = $auction;
        $this->user = $user;
    }

    private function error_messages($key)
    {
        $arr = [
            'auth_error'                  => \Constant::get('PLEASE_LOGIN'),
            'exceeded_personal_bid_limit' => \Constant::get('EXCEEDED_PERSONAL_BID_LIMIT'),
            'bid_limit'                   => \Constant::get('EXCEEDED_BID_LIMIT'),
            'no_ballance'                 => 'Что бы сделать ставку необходимо пополнить свой баланс минимум на ' . setting('bid_price') . ' Лея',
            'no_qty'                      => 'Товара нет в наличии'
        ];

        return $arr[$key];
    }

    public function canMakeBids()
    {
        if(!$this->user)
        {
            $this->_setErrorCode('auth_error');
            return;
        }
        elseif($this->user->bids->count() >= $this->auction->personal_bid_limit)
        {
            $this->_setErrorCode('exceeded_personal_bid_limit');
            return;
        }
        elseif($this->auction->bids_count >= $this->auction->total_bid_limit)
        {
            $this->_setErrorCode('bid_limit');
            return;
        }
        elseif ($this->user->ballance < setting('bid_price'))
        {
            $this->_setErrorCode('no_ballance');
            return;
        }
        elseif (!$this->auction->quantity)
        {
            $this->_setErrorCode('no_qty');
            return;
        }
        return true;
    }

    private function _setErrorCode($code)
    {
        $this->error_code = $code;
    }

    public function getErrorMessage()
    {
        return $this->error_messages($this->error_code);
    }
}