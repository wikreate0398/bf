<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auctions\Auctions;
use App\Models\Auctions\AuctionTypes;
use App\Models\Auctions\ProductTypes;
use App\Utils\UploadImage;

class AuctionsController extends Controller
{
    private $method = 'specific-auctions/auctions';

    private $folder = 'auctions';

    private $uploadFolder = 'auctions';

    private $redirectRoute = 'specific_admin_auctions';

    private $returnDataFields = ['name', 'description', 'seo_keywords', 'seo_description', 'seo_title'];

    private $requiredFields = ['product_type', 'auction_type', 'name_en'];

    private $input;

    private static $auction_type = 'specific';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->model  = new Auctions;

        if(\Request::segment(2) == 'classical-auctions')
        {
            self::$auction_type  = 'classical';
            $this->method        = 'classical-auctions/auctions';
            $this->redirectRoute = 'classical_admin_auctions';
        }

        $this->method = config('admin.path') . '/' . $this->method;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    { 
        $data = [
            'data'   => $this->model->orderByRaw('page_up asc, id desc')->where('auction_type', self::$auction_type)->get(),
            'table'  => $this->model->getTable(),
            'method' => $this->method
        ]; 

        return view('admin.'.$this->folder.'.list', $data);
    } 

    public function showAddForm()
    {
        return view('admin.'.$this->folder.'.add', [
            'method' => $this->method,
            'auction_types' => AuctionTypes::orderByRaw('page_up asc, id desc')->get(),
            'product_types' => ProductTypes::orderByRaw('page_up asc, id desc')->get(),
            'auction_type'  => self::$auction_type
        ]);
    }

    private function validation($input)
    {
        foreach($this->requiredFields as $key => $field)
        {
            if(empty($input[$field])) return false;
        }
        return true;
    }

    public function create()
    {
        $this->input = $this->prepareData();
        //exit(print_arr($this->input));
         $this->model->create($this->input);
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', [
            'method'        => $this->method,
            'table'         => $this->model->getTable(),
            'data'          => $this->model->findOrFail($id),
            'auction_types' => AuctionTypes::orderByRaw('page_up asc, id desc')->get(),
            'product_types' => ProductTypes::orderByRaw('page_up asc, id desc')->get(),
            'auction_type'  => self::$auction_type
        ]);
    }

    public function update($id)
    {
        $data        = $this->model->findOrFail($id);
        $this->input = $this->prepareData($data);
        $data->fill($this->input)->save();
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    private function prepareData($data = false)
    {
        $input          = \Language::returnData($this->returnDataFields);
        if($this->validation($input) != true)
        {
            return \JsonResponse::error(['messages' => trans('admin.req_fields')]);
        }

        $uploadImage = new UploadImage;
        $image = $uploadImage->upload('image', $this->uploadFolder);

        if (!empty($image)) {
            $input['image'] = $image;
        }

        if(empty($data->code))
        {
            $input['code'] = $this->generateCode(false, $input['auction_type']);
            if($input['auction_type'] == 'classical')
            {
                $input['code'] = $this->generateCode(false, $input['auction_type']);
            }
        }

        $input['url']   = !empty($input['url']) ? str_slug($input['url'], '-') : str_slug($input['name_en'], '-');
        return $input;
    }

    private function generateCode($count=false, $type)
    {
        $auctions = $this->model->withTrashed()->where('auction_type', $type)->select('code')->get()->map(function($code){
            return  preg_replace('/[^0-9]/','',$code->code);
        })->toArray();

        if(!$count) $count = !empty($auctions) ? max($auctions)+1 : 1;

        $code  = (($type == 'classical') ? 'B' : 'UL') . $count;
        if($this->model->withTrashed()->where('auction_type', $type)->where('code', $code)->count())
        {
            $this->generateCode($count++, $type);
        }
        return $code;
    }
}
