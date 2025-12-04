<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Services\GameService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GameController extends Controller implements HasMiddleware
{
    //
    public $masterView = 'backend.admin.pages.game-management.game';
    protected GameService $service;

    public Game $data;
    public function __construct(GameService $service)
    {
        $this->service = $service;
    }

    public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods

            // Permission middlewares using the Middleware class
            new Middleware('permission:game-list', only: ['index']),
            new Middleware('permission:game-create', only: ['create']),
            new Middleware('permission:game-edit', only: ['edit']),
            new Middleware('permission:game-show', only: ['show']),
            new Middleware('permission:game-trash', only: ['trash']),
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
        return view($this->masterView, [
            'data' => $this->data,
        ]);
    }
    public function trash()
    {
        return view($this->masterView);
    }

    public function config($id)
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
