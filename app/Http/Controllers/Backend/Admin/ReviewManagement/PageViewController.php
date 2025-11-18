<?php

namespace App\Http\Controllers\Backend\Admin\ReviewManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PageViewService;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PageViewController extends Controller implements HasMiddleware
{
    protected $masterView = 'backend.admin.pages.review-management.pageView';
    public function __construct(protected PageViewService $service) {}

    public static function middleware(): array
        {
            return [
                'auth:admin', // Applies 'auth:admin' to all methods

                // Permission middlewares using the Middleware class
                new Middleware('permission:admin-list', only: ['index']),  
                new Middleware('permission:admin-show', only: ['show']),
                new Middleware('permission:admin-trash', only: ['trash']),
            ];
        }

    public function index()
    {
        return view($this->masterView);
    }
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
    public function trash()
    {
        return view($this->masterView);
    }
}
