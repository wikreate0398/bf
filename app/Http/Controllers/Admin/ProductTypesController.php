<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auctions\ProductTypes;
use App\Utils\UploadImage;

class ProductTypesController extends Controller
{

    private $method = 'auctions/product-types';

    private $folder = 'product_types';

    private $redirectRoute = 'admin_product_types';

    private $returnDataFields = ['name'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->model = new ProductTypes;
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
            'data'   => $this->model->orderByRaw('page_up asc, id desc')->get(),
            'table'  => $this->model->getTable(),
            'method' => $this->method
        ]; 

        return view('admin.'.$this->folder.'.list', $data);
    } 

    public function showAddForm()
    {
        return view('admin.'.$this->folder.'.add', ['method' => $this->method]);
    }

    public function create(Request $request, UploadImage $uploadImage)
    {
        $input = \Language::returnData($this->returnDataFields);
        $this->model->create($input);
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', ['method' => $this->method, 'table' => $this->model->getTable(), 'data' => $this->model->findOrFail($id)]);
    }

    public function update($id, UploadImage $uploadImage, Request $request)
    { 
        $data  = $this->model->findOrFail($id); 
        $input = \Language::returnData($this->returnDataFields);
        $data->fill($input)->save(); 
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    } 
}
