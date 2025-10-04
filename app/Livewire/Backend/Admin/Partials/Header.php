<?php

namespace App\Livewire\Backend\Admin\Partials;

use Livewire\Component;

class Header extends Component
{
    public string $breadcrumb = '';
    public function mount(string $breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
    }
    public function render()
    {
        return view('backend.admin.layouts.partials.header');
    }
}
