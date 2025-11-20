<?php

namespace App\Http\Controllers\Backend\Admin\RewardManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AchievementTypeService;
use Illuminate\Routing\Controllers\Middleware;

class AchievementTypeController extends Controller
{


    protected $masterView = 'backend.admin.pages.reward-management.achievement-type';

    public function __construct(protected AchievementTypeService $service) {}

    public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods

            // Permission middlewares using the Middleware class
            new Middleware('permission:achievement-type-list', only: ['index']),
            new Middleware('permission:achievement-type-create', only: ['create']),
            new Middleware('permission:achievement-type-edit', only: ['edit']),
            new Middleware('permission:achievement-type-show', only: ['show']),
            new Middleware('permission:achievement-type-trash', only: ['trash']),
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


    public function show(string $encryptedId)
    {
        $data = $this->service->findData(decrypt($encryptedId));
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

    public function trash()
    {
        return view($this->masterView);
    }
}
