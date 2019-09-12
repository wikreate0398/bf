<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transactions\TransactionTypes;

class TransactionTypesController extends Controller
{

    private $method = 'transaction-types';

    private $folder = 'transaction_types';

    private $redirectRoute = 'admin_transaction_types';

    private $returnDataFields = ['name'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->model = new TransactionTypes;
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

    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', ['method' => $this->method, 'table' => $this->model->getTable(), 'data' => $this->model->findOrFail($id)]);
    }

    public function update($id, Request $request)
    { 
        $data  = $this->model->findOrFail($id); 
        $input = \Language::returnData($this->returnDataFields);      
        $data->fill($input)->save(); 
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    } 
}
