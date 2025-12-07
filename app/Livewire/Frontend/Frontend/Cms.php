<?php

namespace App\Livewire\Frontend\Frontend;

use App\Enums\CmsType;
use Livewire\Component;
use App\Services\CmsService;

class Cms extends Component
{
    public $type;
    public $typeEnum;

    protected CmsService $service;
    public function boot(CmsService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->typeEnum = CmsType::from($this->type);
    }


    public function render()
    {
        $cms = $this->service->getByType($this->type);
        return view('livewire.frontend.frontend.cms', [
            'cms' => $cms,
        ]);
    }
}
