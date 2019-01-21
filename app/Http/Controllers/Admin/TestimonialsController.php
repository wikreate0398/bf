<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Testimonials;
use App\Utils\UploadImage;

class TestimonialsController extends Controller
{

    private $method = 'front-page/testimonials';

    private $folder = 'testimonials';

    private $uploadFolder = 'testimonials';

    private $redirectRoute = 'admin_testimonials';

    private $returnDataFields = ['name', 'review'];

    private $requiredFields = ['name_en'];

    private $input;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->model  = new Testimonials;
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
        return view('admin.'.$this->folder.'.add', [
            'method' => $this->method,
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
        $this->model->create($this->input);
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', [
            'method'        => $this->method,
            'table'         => $this->model->getTable(),
            'data'          => $this->model->findOrFail($id),
            'folder'        => $this->uploadFolder
        ]);
    }

    public function update($id)
    {
        $this->input = $this->prepareData();
        $data        = $this->model->findOrFail($id);
        $data->fill($this->input)->save();
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    private function prepareData()
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

        return $input;
    }
}
