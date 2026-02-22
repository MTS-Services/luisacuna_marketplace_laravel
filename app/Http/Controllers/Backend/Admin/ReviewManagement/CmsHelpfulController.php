<?php

namespace App\Http\Controllers\Backend\Admin\ReviewManagement;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CmsHelpfulController extends Controller implements HasMiddleware
{
    protected string $masterView = 'backend.admin.pages.review-management.cmsHelpful';

    public static function middleware(): array
    {
        return [
            'auth:admin',
            new Middleware('permission:review-list', only: ['index']),
        ];
    }

    public function index()
    {
        return view($this->masterView);
    }
}
