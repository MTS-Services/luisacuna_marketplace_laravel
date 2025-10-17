<?php

namespace App\Http\Controllers\Backend\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $masterView = 'backend.admin.pages.user-management.user.user';

    public function index()
    {
        return view($this->masterView);
    }
    public function create()
    {
        return view($this->masterView);
    }
    public function view(string $id){
        $user = User::find($id);
        if(!$user){
            abort(404);
        }else{
            return view($this->masterView,[
                'user' => $user
            ]);
        }
    }
    public function edit(string $id)
    {
        $user = User::find($id);
        if(!$user){
            abort(404);
        }else{
            return view($this->masterView,[
                'user' => $user
            ]);
        }
    }
    public function trash()
    {
        return view($this->masterView);
    }
    public function profileInfo($id)
    {
       $user = User::find($id);
        if(!$user){
            abort(404);
        }else{
            return view($this->masterView,[
                'user' => $user
            ]);
        }
    }
    public function shopInfo($id)
    {
       $user = User::find($id);
        if(!$user){
            abort(404);
        }else{
            return view($this->masterView,[
                'user' => $user
            ]);
        }
    }
}
