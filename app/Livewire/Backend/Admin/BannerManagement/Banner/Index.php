<?php

namespace App\Livewire\Backend\Admin\BannerManagement\Banner;

use App\Enums\HeroStatus;
use App\Services\HeroService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;

    protected HeroService $heroService;
    public function boot(HeroService $heroService)
    {
        $this->heroService = $heroService;
    }
    public function render()
    {
        $data
          = $this->heroService->getFristData();
        $datas->load('creater_admin');


        return view('livewire.backend.admin.banner-management.banner.index', [
            'data' => $data,
            'statuses' => HeroStatus::options(),
        ]);
    }
}
