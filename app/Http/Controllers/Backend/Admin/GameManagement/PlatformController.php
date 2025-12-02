<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Services\PlatformService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PlatformController extends Controller implements HasMiddleware
{
    public function __construct(protected PlatformService $service) {}

    //
    public $master = 'backend.admin.pages.game-management.platform';

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

        return view($this->master);
    }

    public function create()
    {

        return view($this->master);
    }

    public function edit($encryptedId)
    {

        $data = $this->service->findData(decrypt($encryptedId));

        if (! $data) {
            abort(404);
        }


        return view($this->master, [

            'data' => $data,
        ]);
    }

    public function show($encryptedId)
    {


        $data = $this->service->findData(decrypt($encryptedId));


        if (! $data) {
            abort(404);
        }

        return view($this->master, [
            'data' => $data
        ]);
    }

    public function trash()
    {

        return view($this->master);
    }
}
