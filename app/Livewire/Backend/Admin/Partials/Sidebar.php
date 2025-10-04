<?php

namespace App\Livewire\Backend\Admin\Partials;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public string $active = '';

    public function mount(string $active)
    {
        $this->active = $active;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return $this->redirectRoute('home', navigate: true);
    }
    public function render()
    {
        return view('backend.admin.layouts.partials.sidebar');
    }
}
