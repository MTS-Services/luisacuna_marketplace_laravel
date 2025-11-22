<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Services\ServerService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ServerController extends Controller implements HasMiddleware
{
    public function __construct(protected ServerService $service) {}

    //
    public $master = 'backend.admin.pages.game-management.server';

    public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods

            // Permission middlewares using the Middleware class
            new Middleware('permission:server-list', only: ['index']),
            new Middleware('permission:server-create', only: ['create']),
            new Middleware('permission:server-edit', only: ['edit']),
            new Middleware('permission:server-show', only: ['view']),
            new Middleware('permission:server-trash', only: ['trash']),
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
