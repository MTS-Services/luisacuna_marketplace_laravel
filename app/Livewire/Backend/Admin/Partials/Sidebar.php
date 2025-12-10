<?php

namespace App\Livewire\Backend\Admin\Partials;

use Livewire\Component;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    public string $active = '';
    public $categories;


    protected CategoryService $categoryService;

    public function boot(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function mount(string $active)
    {
        $this->active = $active;
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
    public function render()
    {
        $this->categories = $this->categoryService->getDatas(status: "active");
        return view('backend.admin.layouts.partials.sidebar');
    }
}
