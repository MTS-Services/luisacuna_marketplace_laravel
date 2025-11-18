<?php

namespace App\Http\Controllers\Backend\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class LanguageController extends Controller implements HasMiddleware
{


    protected $masterView = 'backend.admin.pages.settings.language';
    public function __construct(protected LanguageService $service) {}

    public static function middleware(): array
        {
            return [
                'auth:admin', // Applies 'auth:admin' to all methods

                // Permission middlewares using the Middleware class
                new Middleware('permission:admin-list', only: ['index']),
                new Middleware('permission:admin-create', only: ['create']),
                new Middleware('permission:admin-edit', only: ['edit']),
                new Middleware('permission:admin-view', only: ['view']),
                new Middleware('permission:admin-trash', only: ['trash']),
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


     public function view(string $encryptedId)
    {
        $data = $this->service->findData(decrypt($encryptedId));
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }

    // public function view(string $id)
    // {
    //     $data = Language::find($id);
    //     if (!$data) {
    //         abort(404);
    //     }
    //     return view($this->masterView, [
    //         'data' => $data
    //     ]);
    // }

    public function trash()
    {
        return view($this->masterView);
    }
}
