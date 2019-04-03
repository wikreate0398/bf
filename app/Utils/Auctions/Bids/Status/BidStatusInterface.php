<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.03.2019
 * Time: 11:01
 */

namespace App\Utils\Auctions\Bids\Status;


interface BidStatusInterface
{
    public function get();

    public function status();
}