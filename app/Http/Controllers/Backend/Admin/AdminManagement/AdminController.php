<?php

namespace App\Http\Controllers\Backend\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Services\Admin\AdminManagement\RoleService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{
    protected $masterView = 'backend.admin.pages.admin-management.admin.admin';

    public function __construct(protected AdminService $service)
    {
    }


     public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods

            // Permission middlewares using the Middleware class
            new Middleware('permission:admin-list', only: ['index']),
            new Middleware('permission:admin-create', only: ['create']),
            new Middleware('permission:admin-edit', only: ['edit']),
            new Middleware('permission:admin-view', only: ['view']),
            new Middleware('permission:admin-trash', only: ['trash']),
        ];
    }

    public function index()
    {
        return view($this->masterView);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view($this->masterView);
    }

    /**
     * Display the specified resource.
     */

    public function edit(string $encryptedId)
    {
        $data = $this->service->findData(decrypt($encryptedId));
        if (!$data) {
            abort(404);
        }

        return view($this->masterView, [
            'data' => $data
        ]);

    }

     public function view(string $encryptedId)
    {
        $data = $this->service->findData(decrypt($encryptedId));
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }

    public function trash()
    {
        return view($this->masterView);
    }

}
