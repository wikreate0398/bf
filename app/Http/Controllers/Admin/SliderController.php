<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Utils\UploadImage;

class SliderController extends Controller
{

    private $method = 'slider'; 

    private $folder = 'slider';

    private $redirectRoute = 'admin_slider';

    private $returnDataFields = ['name', 'description'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->model = new Slider;
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
        $input['image'] = $uploadImage->upload('image', 'slider');
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
        $image = $uploadImage->upload('image', 'slider');

        if (!empty($image)) {
            $input['image'] = $image;
        }
           
        $data->fill($input)->save(); 
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    } 
}
