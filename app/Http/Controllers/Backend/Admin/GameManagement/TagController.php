<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Services\TagService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TagController extends Controller implements HasMiddleware
{
    public function __construct(protected TagService $service) {}

    //
    public $master = 'backend.admin.pages.game-management.tag';

    public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods

            // Permission middlewares using the Middleware class
            new Middleware('permission:tag-list', only: ['index']),
            new Middleware('permission:tag-create', only: ['create']),
            new Middleware('permission:tag-edit', only: ['edit']),
            new Middleware('permission:tag-show', only: ['view']),
            new Middleware('permission:tag-trash', only: ['trash']),
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
