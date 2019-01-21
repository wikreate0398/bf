<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\UploadImage;

use App\Models\Banner\Banner;
use App\Models\Banner\BannerPages;
use App\Models\Menu;
use App\Models\Auctions\Auctions;

class BannerController extends Controller
{

    private $method = 'banners';

    private $folder = 'banners';

    private $uploadFolder = 'banners';

    private $redirectRoute = 'admin_banner';

    private $returnDataFields = [];

    private $requiredFields = ['name'];

    private $input;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->model  = new Banner;
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
            'data'   => $this->model->orderByRaw('id desc')->get(),
            'table'  => $this->model->getTable(),
            'method' => $this->method
        ]; 

        return view('admin.'.$this->folder.'.list', $data);
    } 

    public function showAddForm()
    {
        return view('admin.'.$this->folder.'.add', [
            'method' => $this->method,
            'folder' => $this->folder,
            'menu'   => Menu::orderByRaw('page_up asc, id desc')->get(),
            'auctions' => Auctions::orderByRaw('page_up asc, id desc')->get()
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
        $id          = $this->model->create($this->input)->id;
        $this->saveBannerPages($id);

        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    private function saveBannerPages($id, $insert = [])
    {
        BannerPages::where('id_banner', $id)->delete();

        if(!empty($this->input['auctions']))
        {
            foreach ($this->input['auctions'] as $idPage => $value) {
                $insert[] = [
                    'id_banner' => $id,
                    'type'      => 'product',
                    'id_page'   => $idPage
                ];
            }
            BannerPages::insert($insert);
        }

        if(!empty($this->input['pages']))
        {
            foreach ($this->input['pages'] as $idPage => $value) {
                $insert[] = [
                    'id_banner' => $id,
                    'type'      => 'page',
                    'id_page'   => $idPage
                ];
            }
        }

        if(!empty($insert))
        {
            BannerPages::insert($insert);
        }
    }

    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', [
            'method' => $this->method,
            'table'  => $this->model->getTable(),
            'data'   => $this->model->findOrFail($id),
            'folder' => $this->folder,
            'menu'   => Menu::orderByRaw('page_up asc, id desc')->get(),
            'auctions' => Auctions::orderByRaw('page_up asc, id desc')->get()
        ]);
    }

    public function update($id)
    {
        $data        = $this->model->findOrFail($id);
        $this->input = $this->prepareData($data);
        $data->fill($this->input)->save();
        $this->saveBannerPages($id);
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    private function prepareData($data = false)
    {
        $input          = \Language::returnData($this->returnDataFields);
        if($this->validation($input) != true)
        {
            return \JsonResponse::error(['messages' => trans('admin.req_fields')]);
        }

        $uploadImage      = new UploadImage;
        $image_top        = $uploadImage->upload('image_top', $this->uploadFolder);
        $image_side       = $uploadImage->upload('image_side', $this->uploadFolder);
        $image_background = $uploadImage->upload('image_background', $this->uploadFolder);

        if(!empty($image_top))
        {
            $input['image_top'] = $image_top;
        }
        if(!empty($image_side))
        {
            $input['image_side']  = $image_side;
        }
        if(!empty($image_background))
        {
            $input['image_background'] = $image_background;
        }

        return $input;
    }
}
