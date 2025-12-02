<?php

namespace App\Livewire\Backend\Admin\BannerManagement\Banner;

use App\Enums\HeroStatus;
use App\Livewire\Forms\BannerForm;
use App\Models\Hero;
use App\Services\HeroService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithDataTable, WithNotification, WithFileUploads;


    public BannerForm $form;
    protected HeroService $heroService;
    public ?string $existingFile = null;
    public Hero $data;
    public function boot(HeroService $heroService)
    {
        $this->heroService = $heroService;
    }
    public function render()
    {
        $data = $this->heroService->getFristData();
        
        $this->data = $data;

        if($data->image){
            $this->existingFile = $data->image;
        }
        $this->form->setData($data);
        return view('livewire.backend.admin.banner-management.banner.index', [
            'statuses' => HeroStatus::options(),
        ]);
    }
}
