<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.03.2019
 * Time: 0:44
 */

namespace App\Console\Commands\OrderTypes;


interface OrderTypesInterface
{
    public function getWinnerBid();
}