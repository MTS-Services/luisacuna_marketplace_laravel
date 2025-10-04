<?php

namespace App\Livewire\Backend\Admin\Components;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'Admin Dashboard',
        'breadcrumb' => 'Admin Dashboard',
        'page_slug' => 'admin-dashboard'
    ]
)]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.backend.admin.dashboard');
    }
}
