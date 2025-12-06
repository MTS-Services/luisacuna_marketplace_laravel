<?php

namespace App\Http\Controllers\Backend\Admin\FaqManagement;
use App\Services\FaqService;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class FaqController extends Controller implements HasMiddleware
{

    /**
     * Master Blade View
     */

    protected string $masterView = 'backend.admin.pages.faq-management.faq';

    /**
     * Register Middlewares
     */

    public static function middleware(): array
    {
        return [
            'auth:admin',
            // new Middleware('permission:faq-list', only: ['index']),
            // new Middleware('permission:faq-create', only: ['create']),
            // new Middleware('permission:faq-edit', only: ['edit']),
            // new Middleware('permission:faq-show', only: ['show']),
            // new Middleware('permission:faq-trash', only: ['trash']),
        ];
    }

    /**
     * Inject FaqService
     */

    private $service;

    public function __construct(FaqService $service)
    {
        $this->service = $service;
    }

    /**
     * FAQ List Page
     */


    public function index(): View
    {
        return view($this->masterView);
    }

    /**
     * FAQ Create Page
     */

    public function create(): View
    {
        return view($this->masterView);
    }

    /**
     * FAQ Edit Page
     */

    public function edit(string $encryptedId): View
    {
        $id = decrypt($encryptedId);
        $data = $this->service->findData($id);

        abort_if(!$data, 404);

        return view($this->masterView, compact('data'));
    }

    /**
     * FAQ Show Page
     */
    public function show(string $encryptedId): View
    {
        $id = decrypt($encryptedId);
        $data = $this->service->findData($id);

        abort_if(!$data, 404);

        return view($this->masterView, compact('data'));
    }

    /**
     * FAQ Trash Page
     */
    public function trash(): View
    {
        return view($this->masterView);
    }
}
