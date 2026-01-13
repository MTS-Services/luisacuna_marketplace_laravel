<?php

namespace App\Livewire\Frontend\Frontend;

use App\Enums\CmsType;
use App\Enums\HelpfulType;
use Livewire\Component;
use App\Services\CmsService;
use App\Services\HelpfullService;
use App\Traits\Livewire\WithNotification;

class Cms extends Component
{
    use WithNotification;
    public $type;
    public $typeEnum;

    public int $cmsId;
    protected CmsService $service;
    protected HelpfullService $helpfullService;
    public function boot(CmsService $service, HelpfullService $helpfullService)
    {
        $this->service = $service;
        $this->helpfullService = $helpfullService;
    }

    public function mount()
    {
        $this->typeEnum = CmsType::from($this->type);
    }

    public function useful()
    {
        $postive = HelpfulType::POSITIVE->value;
        $data = [
            'type' => $postive,
            'cms_id' => $this->cmsId
        ];
        $this->helpfullService->createData($data);
        
        $this->toastInfo('Feedback Updated');
    }

    public function notUseful()
    {
        $postive = HelpfulType::NEGATIVE->value;
        $data = [
            'type' => $postive,
            'cms_id' => $this->cmsId
        ];
        $this->helpfullService->createData($data);

        $this->toastInfo('Feedback Updated');
  
    }

    public function render()
    {
        $cms = $this->service->getByType($this->type);
        if($cms?->id != null){
            $this->cmsId = $cms?->id;
        }
        return view('livewire.frontend.frontend.cms', [
            'cms' => $cms,
        ]);
    }
}
