<?php

namespace App\Utils;
use Illuminate\Http\Request;
use \App\Models\Banner\Banner;
use \App\Models\Banner\BannerPages;

class Banner
{  
    private $type;

    private $id_page;

    private $position;

    function __construct() {}

    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    public function page($id)
    {
        $this->id_page = $id;
        return $this;
    }

    public function position($position)
    {
        $this->position = in_array($position, ['top', 'background', 'side']) ? $position : 'top';
        return $this;
    }

    public function get()
    {
        $bannersPages = BannerPages::where('type', $this->type)
                                   ->where('id_page', $this->id_page) 
                                   ->get();

        $banners = Banner::whereIn('id', $bannersPages->pluck('id_banner')->toArray())->get();
        return @$banners[0];
    } 
}