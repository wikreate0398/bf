<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  
use Illuminate\Support\Facades\Validator;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{ 
  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}
  
    public function showForm()
    { 
        return view('admin.profile.view', ['users' => AdminUser::where('id', '!=', Auth::id())->orderBy('id', 'desc')->get(), 'table' => (new AdminUser)->getTable()]);
    }

    public function addNewUser(Request $request)
    {
        $validator = Validator::make($request->all(), $rules = [ 
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
            'email'                 => 'required|min:4|unique:admin_users'
        ], ['unique' => trans('admin.already_exits')]);

        $validator->setAttributeNames([
            'password'         => 'Password',
            'repeat_password'  => 'Repeat Password',
            'email'            => 'Login/E-mail'
        ]); 
 
        if ($validator->fails()) 
        {   
            return \App\Utils\JsonResponse::error(['messages' => $validator->errors()->toArray()]); 
        }

        $checkLogin = AdminUser::whereEmail($request->input('login'))->first();
        if (!empty($checkLogin)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => trans('admin.already_exits')]);
        }

        $data = $request->all();

        AdminUser::create([
            'name'     => $data['name'],
            'password' => bcrypt($data['password']),
            'email'    => $data['email'] 
        ]);

        return \App\Utils\JsonResponse::success(['redirect' => route('profile')], trans('admin.added_user')); 
    }

    public function edit(Request $request)
    { 
        $validator = Validator::make($request->all(), $rules = [ 
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ], ['unique' => trans('admin.already_exits')]);

        $validator->setAttributeNames([
            'password'         => 'Password',
            'repeat_password'  => 'Repeat Password'
        ]); 

        if ($validator->fails()) 
        {  
            return \App\Utils\JsonResponse::error(['messages' => $validator->errors()->toArray()]); 
        }
 
        $data   = AdminUser::findOrFail(Auth::id());     
        $update = $request->all();
        $update['password'] = bcrypt($request->input('password'));
        $data->fill($update)->save(); 
        return \App\Utils\JsonResponse::success(['redirect' => route('profile')], trans('admin.update_pass')); 
    }

    public function showLogsReport($idUser)
    {
        return view('admin.profile.logs_report', [
            'user'      => AdminUser::whereId($idUser)->firstOrFail(),
            'pageTitle' => 'Logs report'
        ]);
    }
}
