<?php

function setScript($js_folder, $path){
    if (strpos($path, 'full:') !== false) {
        $path = str_replace('full:', '', $path); 
    }else{
        $path = $js_folder.$path.'?v='.time();
    }
    return "<script src='{$path}'></script>";
}

if (!function_exists('key_to_id')) {
    function key_to_id($array) {
        if (empty($array)) {
            return array();
        }
        $new_arr = array();
        foreach ($array as $id => &$node) {
            $new_arr[$node['id']] =& $node;
        }
        return $new_arr;
    }
}

function sortValue($arr){
    if (empty($arr)) return;

    $data = array();
    foreach ($arr as $l_key => $l_value)
    {
        $i=0;
        foreach ($l_value as $key => $value)
        {
            $data[$key][$l_key] = $arr[$l_key][$key];
            $i++;
        }
    }
    return $data;
}

if (!function_exists('map_tree')) {
    function map_tree($dataset)
    {
        $dataset = key_to_id($dataset);
        $tree    = array();
        foreach ($dataset as $id => &$node) {
            if (empty($node['parent_id'])) {
                $tree[$id] =& $node;
            } else {
                $dataset[$node['parent_id']]['childs'][$id] =& $node;
            }
        }
        return $tree;
    }
}

function d()
{
    array_map(function ($x) {
        (new \Illuminate\Support\Debug\Dumper)->dump($x);
    }, func_get_args());
}

if (!function_exists('print_arr')) {
    function print_arr($array)
    {
        echo "<pre>" . print_r($array, true) . "</pre>";
    }
}

function setAdminUri($uri)
{
    return '/' . config('admin.path') .  '/' . $uri;
}

function prepareArrayForJson($array)
{
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    return str_replace($escapers, $replacements, json_encode($array));
}

function userRoute($route)
{ 
    $define = Auth::user()->userType->define;
    return $define . '_' . $route;
}

function isActive($route, $domain='')
{   
    return (request()->url() == $route) ? true :  false;
}

function adminMenu()
{
    return [
        'menu' => [
            'name' => 'Menu',
            'icon' => '<i class="fa fa-bars" aria-hidden="true"></i>',
            'link' => '/'.config('admin.path').'/menu/',
            'view' => true,
            'edit' => 'Edit'
        ], 

        'classical-auctions' => [
            'name'   => 'Classical Auctions',
            'icon'   => '<i class="fa fa-gavel" aria-hidden="true"></i>',
            'link'   => '/'.config('admin.path').'/front-page/',
            'view'   => true,
            'edit'   => 'Редактировать',
            'childs' => [
                'auctions' => [
                    'name' => 'Current Auctions',
                    'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
                    'link' => '/'.config('admin.path').'/classical-auctions/auctions/',
                    'view' => true,
                    'edit' => 'Редактировать'
                ],

                'add-auctions' => [
                    'name' => 'Add Auction',
                    'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
                    'link' => '/'.config('admin.path').'/classical-auctions/auctions/add',
                    'view' => true,
                    'edit' => 'Редактировать'
                ],

//                'auction-types' => [
//                    'name' => 'Auction types',
//                    'icon' => '<i class="fa fa-list-ol" aria-hidden="true"></i>',
//                    'link' => '/'.config('admin.path').'/auctions/auction-types/',
//                    'view' => true,
//                    'edit' => 'Edit'
//                ],
//
//                'product-types' => [
//                    'name' => 'Product types',
//                    'icon' => '<i class="fa fa-list-ol" aria-hidden="true"></i>',
//                    'link' => '/'.config('admin.path').'/auctions/product-types/',
//                    'view' => true,
//                    'edit' => 'Edit'
//                ],
            ]
        ],

        'specific-auctions' => [
            'name'   => 'Specific Auctions',
            'icon'   => '<i class="fa fa-gavel" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i>',
            'link'   => '/'.config('admin.path').'/front-page/',
            'view'   => true,
            'edit'   => 'Редактировать',
            'childs' => [
                'auctions' => [
                    'name' => 'Current Auctions',
                    'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
                    'link' => '/'.config('admin.path').'/specific-auctions/auctions/',
                    'view' => true,
                    'edit' => 'Редактировать'
                ],

                'add-auctions' => [
                    'name' => 'Add Auction',
                    'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
                    'link' => '/'.config('admin.path').'/specific-auctions/auctions/add',
                    'view' => true,
                    'edit' => 'Редактировать'
                ],
            ]
        ],


        'front-page' => [
            'name'   => 'Front page',
            'icon'   => '<i class="fa fa-television" aria-hidden="true"></i>',
            'link'   => '/'.config('admin.path').'/front-page/',
            'view'   => true,
            'edit'   => 'Редактировать',
            'childs' => [
                'testimonials' => [
                    'name' => 'Testimonials',
                    'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
                    'link' => '/'.config('admin.path').'/front-page/testimonials/',
                    'view' => true,
                    'edit' => 'Редактировать'
                ],

            ]
        ],

        'e-vouchers' => [
            'name' => 'E-voucher options',
            'icon' => '<i class="fa fa-volume-control-phone" aria-hidden="true"></i>',
            'link' => '/'.config('admin.path').'/e-vouchers/',
            'view' => true,
            'edit' => 'Edit'
        ],

        'banners' => [
            'name' => 'Banners',
            'icon' => '<i class="fa fa-file-image-o" aria-hidden="true"></i>',
            'link' => '/'.config('admin.path').'/banners/',
            'view' => true,
            'edit' => 'Edit'
        ],

        'settings' => [
            'name' => 'Settings',
            'icon' => '<i class="fa fa-sliders" aria-hidden="true"></i>',
            'link' => '/'.config('admin.path').'/settings/',
            'view' => true,
            'edit' => 'Edit'
        ],

        'constants' => [
            'name' => 'Constants',
            'icon' => '<i class="fa fa-anchor" aria-hidden="true"></i>',
            'link' => '/'.config('admin.path').'/constants/',
            'view' => true,
            'edit' => 'Edit'
        ],

        // Скрытые страницы

        'profile' => [
            'name' => 'Profile',
            'link' => '/'.config('admin.path').'/profile/',
            'view' => false,
            'edit' => 'Edit'
        ], 
    ]; 
}

//function auctionType($type){
//    $types = [
//        ''
//    ];
//}

function setting($key)
{
    return \App\Utils\Settings::get($key);
}

function key_to_id($array) {
    if (empty($array)) {
        return array();
    }
    $new_arr = array();
    foreach ($array as $id => &$node) {
        $new_arr[$node['id']] =& $node;
    }
    return $new_arr;
}



function tree($dataset)
{
    if($dataset instanceof Illuminate\Database\Eloquent\Collection){
        $dataset = $dataset->toArray();
    }
    $dataset = key_to_id($dataset);
    $tree    = array();
    foreach ($dataset as $id => &$node) {
        if (!$node['parent_id']) {
            $tree[$id] =& $node;
        } else {
            $dataset[$node['parent_id']]['childs'][$id] =& $node;
        }
    }
    return $tree;
}

function uri($segment)
{
    return request()->segment($segment);
}

function lang()
{
    return \App::getLocale();
}

function setUri($uri){
    return '/' . lang() . '/' . $uri;
}

function priceString($price){ 
    if (empty($price)) return '0.00'; 
    return number_format($price, 0, '.', ' ');
}

function toFloat($s) {
    // convert "," to "."
    $s = str_replace(',', '.', $s);

    // remove everything except numbers and dot "."
    $s = preg_replace("/[^0-9\.]/", "", $s);

    // remove all seperators from first part and keep the end
   // $s = str_replace('.', '',substr($s, 0, -3)) . substr($s, -3);

    // return float
    return (float) $s;
}  

function uploadBase64($base64, $path){
    $data = $base64;
    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));    
    file_put_contents($path, $data); 
}

function setLangUri($lang){
    $url  = \Request::path();

    $a    = array_slice(explode('/', $url), 1);
    $b    = implode('/', $a);
    $link = $b.(!empty(\Request::server('QUERY_STRING')) ? '?'.\Request::server('QUERY_STRING') : '');

    return "/$lang/" .$link;
}

function imageThumb($image, $path, $width, $height, $v)
{
    $path = str_replace('.', '/', $path); 

    $thumbPath = '/thumb';
    if (!is_dir(public_path($path . "/thumb"))) 
    {  
        mkdir(public_path($path . "/thumb"), 0777);
        chmod(public_path($path . "/thumb"), 0777);
    }

    if (!empty($v)) 
    {
        if (!is_dir(public_path($path . "/thumb/version_$v"))) 
        { 
            mkdir(public_path($path . "/thumb/version_$v"), 0777);
            chmod(public_path($path . "/thumb/version_$v"), 0777);
        }
        $thumbPath .= "/version_$v";
    }
    
    $imgeThumbnailPath = public_path($path . $thumbPath . "/$image");
    $filePath          = public_path($path . "/$image");

    if (!file_exists($imgeThumbnailPath) && file_exists($filePath)) 
    {   
        $img = Image::make($filePath)->fit($width, $height, function ($constraint) {
            $constraint->upsize();
        });
        $img->save($imgeThumbnailPath);
    }  

    if (!file_exists($imgeThumbnailPath) or empty($image)) 
    {
        return "http://via.placeholder.com/{$width}x{$height}/00d2ff/ffffff";
    }

    return env('APP_URL') . '/' . $path . $thumbPath . "/$image"; 
}

function getDiffYears($date)
{
    $d1 = new DateTime(date('Y-m-d'));
    $d2 = new DateTime($date); 
    $diff = $d2->diff($d1);  
    return $diff->y;
}

function getDiffDateTime($date)
{
    $d1 = new DateTime(date('Y-m-d H:i:s'));
    $d2 = new DateTime($date); 
    $diff = $d2->diff($d1);  
    return $diff;
}

function montName($date)
{
    $date = strtotime($date);
    $_nr_month = date('m', $date);
    switch ($_nr_month) {
        case '01':
            $m = 'Января';
            break;
        case '02':
            $m = 'Февраля';
            break;
        case '03':
            $m = 'Марта';
            break;
        case '04':
            $m = 'Апреля';
            break;
        case '05':
            $m = 'Мая';
            break;
        case '06':
            $m = 'Июня';
            break;
        case '07':
            $m = 'Июля';
            break;
        case '08':
            $m = 'Августа';
            break;
        case '09':
            $m = 'сентября';
            break;
        case '10':
            $m = 'Октября';
            break;
        case '11':
            $m = 'Ноября';
            break;
        case '12':
            $m = 'Декабря';
            break;
        default:
            $m = $to_date;
            break;
    }
    return date('d ' . $m . ' Y', $date);
}