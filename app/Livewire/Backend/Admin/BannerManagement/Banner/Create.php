<?php

namespace App\Livewire\Backend\Admin\BannerManagement\Banner;

use App\Enums\HeroStatus;
use Livewire\Component;

class Create extends Component
{
    public function render()
    {
        return view('livewire.backend.admin.banner-management.banner.create',
        [
            'statuses' => HeroStatus::options()
        ]    
    );
    }   
}
