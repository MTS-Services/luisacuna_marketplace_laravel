<?php

namespace App\Http\Controllers\Backend\Admin\NotificationManagement;

use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Services\NotificatonService;

class NotificationController extends Controller
{
    protected NotificatonService $service;
    protected $masterView = 'backend.admin.pages.notification-management.notification';
    public function __construct(NotificatonService $service)
    {
        $this->service = $service;
    }



    public function index()
    {
        return view($this->masterView);
    }

    public function send()
    {
        return view($this->masterView);
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
}
