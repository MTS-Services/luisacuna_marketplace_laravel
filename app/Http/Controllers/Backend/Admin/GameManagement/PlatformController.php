<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use App\Services\PlatformService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PlatformController extends Controller implements HasMiddleware
{
    public $masterView = 'backend.admin.pages.game-management.platform';
    //
    protected PlatformService $service;

    public Platform $data;
    public function __construct(PlatformService $service)
    {
        $this->service = $service;
    }

    public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods

            // Permission middlewares using the Middleware class
            new Middleware('permission:platform-list', only: ['index']),
            new Middleware('permission:platform-create', only: ['create']),
            new Middleware('permission:platform-edit', only: ['edit']),
            new Middleware('permission:platform-show', only: ['view']),
            new Middleware('permission:platform-trash', only: ['trash']),
        ];
    }


    public function index()
    {
        return view($this->masterView);
    }

    public function create()
    {
        return view($this->masterView);
    }

    public function show($id)
    {
        $this->data = $this->service->findData(decrypt($id));
        if (!$this->data) {
            abort(404);
        }

        return view($this->masterView, [
            'data' => $this->data,
        ]);
    }
    public function edit($id)
    {
        $this->data = $this->service->findData(decrypt($id));

        if (!$this->data) {
            abort(404);
        }

        return view($this->masterView, [
            'data' => $this->data,
        ]);
    }
    public function trash()
    {
        return view($this->masterView);
    }
}
