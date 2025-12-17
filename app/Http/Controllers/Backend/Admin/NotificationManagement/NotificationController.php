<?php

namespace App\Http\Controllers\Backend\Admin\NotificationManagement;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $masterView = 'backend.admin.pages.notification-management.notification';

    public function __construct(protected NotificationService $notificationService) {}

    public function index()
    {
        return view($this->masterView);
    }
    public function show($encryptedId)
    {
        return view($this->masterView, compact('encryptedId'));
    }
}
