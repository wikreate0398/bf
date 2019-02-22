<?php

namespace App\Utils;
use Illuminate\Http\Request;
use \App\Models\Menu;

/**
 *
 */
class Pages
{
    private static $_page_data;

    function __construct() {}

    public function top()
    {
        return Menu::where('view_top', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get();
    }

    public static function bottom()
    {
        return Menu::where('view_bottom', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get();
    }

    public function active($url)
    {
        (request()->segment(1) == $url) ? true : false;
    }

    public static function pageData($page_type = false)
    {
        $query = new Menu;
        if(!empty($page_type))
        {
            $query = $query->where('page_type', $page_type);
        }
        else
        {
            $url = \Request::segment(2) ? \Request::segment(2) : '/';
            $query = $query->where('url', $url);
        }
        return $query->first();
    }

    public function uriName()
    {
        return !request()->segment(2) ? '/' : request()->segment(2);
    }

    public function getUriByType($type)
    {
        return @Menu::where('page_type', $type)->first()->url;
    }
}