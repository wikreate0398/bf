<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.03.2019
 * Time: 11:27
 */

namespace App\Utils\Paginate;

use App\Models\Auctions\Auctions;

class PaginateList implements PaginateInterface
{
    private $items = null;

    private $currentIndex = 0;

    public function addItems($items)
    {
        $this->items = $items;
        return $this;
    }

    public function addCurrentIndex($index)
    {
        $this->currentIndex = $index;
        return $this;
    }

    public function count()
    {
        return $this->items->count();
    }

    public function currentKey()
    {
        foreach ($this->items as $key => $items)
        {
            if($items->id == $this->currentIndex or ($this->currentIndex == 0 && $key == 0))
            {
                return $key+1;
            }
        }
    }

    public function current()
    {
        return $this->items->first();
    }

    public function next()
    {
        if($this->count() == 1) return array();

        foreach ($this->items as $key => $item)
        {
            if($item->id == $this->currentIndex && $this->count() >= $key+2)
            {
                return $this->items[$key+1];
            }
        }
    }

    public function previous()
    {
        if($this->count() == 1) return array();

        foreach ($this->items as $key => $item)
        {
            if($item->id == $this->currentIndex && !empty($this->items[$key-1]))
            {
                return $this->items[$key-1];
            }
        }
    }
}