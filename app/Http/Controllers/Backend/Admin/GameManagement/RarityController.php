<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Services\RarityService;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class RarityController extends Controller implements HasMiddleware
{

    protected $masterView = 'backend.admin.pages.game-management.rarity';

    public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods

            // Permission middlewares using the Middleware class
            // new Middleware('permission:rarity-list', only: ['index']),
            // new Middleware('permission:rarity-create', only: ['create']),
            // new Middleware('permission:rarity-edit', only: ['edit']),
            // new Middleware('permission:rarity-show', only: ['view']),
            // new Middleware('permission:rarity-trash', only: ['trash']),
        ];
    }



    protected RarityService $service;
    public function __construct(RarityService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view($this->masterView);
    }

    public function create()
    {
        return view($this->masterView);
    }

    public function edit($encryptedId): View
    {

        $data = $this->service->findData(decrypt($encryptedId));
        return view($this->masterView, [
            'data' => $data
        ]);
    }
    public function show($encryptedId)
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
