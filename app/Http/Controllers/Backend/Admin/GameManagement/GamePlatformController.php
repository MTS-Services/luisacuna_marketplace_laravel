<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Models\GamePlatform;
use App\Services\GamePlatformService;


class GamePlatformController extends Controller
{
    //
    protected GamePlatformService $service;

    public GamePlatform $data;
    public function __construct(GamePlatformService $service)
    {
        $this->service = $service;
    }
    public $masterView = 'backend.admin.pages.game-management.platform';
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
