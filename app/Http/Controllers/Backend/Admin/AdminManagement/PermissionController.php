<?php

namespace App\Http\Controllers\Backend\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Services\PermissionService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    protected $masterView = 'backend.admin.pages.admin-management.permission.permission';

    public function __construct(protected PermissionService $service) {}

    public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods

            // Permission middlewares using the Middleware class
            new Middleware('permission:permission-list', only: ['index']),
            new Middleware('permission:permission-create', only: ['create']),
            new Middleware('permission:permission-edit', only: ['edit']),
            new Middleware('permission:permission-view', only: ['view']),
            new Middleware('permission:permission-trash', only: ['trash']),
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
    public function view(string $id)
    {
        $data = $this->service->findData(decrypt($id));
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->service->findData(decrypt($id));
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }
}
