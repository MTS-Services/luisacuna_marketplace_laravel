<?php

namespace App\Http\Controllers\Backend\Admin\RewardManagement;

use Illuminate\Http\Request;
use App\Services\RankService;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RankController extends Controller implements HasMiddleware
{
    //
    protected $masterView = 'backend.admin.pages.reward-management.rank';

    public function __construct(protected RankService $service) {}


    public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods

            // Permission middlewares using the Middleware class
            new Middleware('permission:rank-list', only: ['index']),
            new Middleware('permission:rank-create', only: ['create']),
            new Middleware('permission:rank-edit', only: ['edit']),
            new Middleware('permission:rank-show', only: ['view']),
            new Middleware('permission:rank-trash', only: ['trash']),
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
