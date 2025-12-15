<?php

namespace App\Http\Controllers\Backend\Admin\NotificationManagement;

use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{
    protected $masterView = 'backend.admin.pages.notification-management.announcement';

    public function index()
    {
        return view($this->masterView);
    }
}
