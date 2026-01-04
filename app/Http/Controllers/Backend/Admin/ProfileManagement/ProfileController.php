<?php

namespace App\Http\Controllers\Backend\Admin\ProfileManagement;

use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    protected $masterView = 'backend.admin.pages.profile-management.profile';

    public function __construct(protected AdminService $service) {}
    public function index()
    {
        return view($this->masterView);
    }

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
}
