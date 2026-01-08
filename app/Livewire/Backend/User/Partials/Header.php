<?php

namespace App\Livewire\Backend\User\Partials;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Header extends Component
{
    public string $pageSlug;
    public string $breadcrumb;

    public function mount(string $pageSlug = 'home', string $breadcrumb = '')
    {
        $this->pageSlug = $pageSlug;
        $this->breadcrumb = $breadcrumb;
    }

    public function render()
    {
        return view('backend.user.layouts.partials.header');
    }
}
