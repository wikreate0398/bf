<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.03.2019
 * Time: 11:26
 */

namespace App\Utils\Paginate;


interface PaginateInterface
{
    public function currentKey();

    public function current();

    public function previous();

    public function next();
}