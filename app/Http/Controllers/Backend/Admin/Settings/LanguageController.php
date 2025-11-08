<?php

namespace App\Http\Controllers\Backend\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Services\LanguageService;
use Illuminate\Http\Request;

class LanguageController extends Controller
{


    protected $masterView = 'backend.admin.pages.settings.language';
     public function __construct(protected LanguageService $service) {}

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