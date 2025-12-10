<?php

namespace App\Livewire\Backend\Admin\BannerManagement\Banner;

use App\Enums\HeroStatus;
use App\Livewire\Forms\BannerForm;
use App\Services\HeroService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{

    use WithFileUploads, WithNotification;
    public $data;
    public BannerForm $form;
    public ?string $existingFile = null;
    public ?string $existingFileMobile = null;

    protected HeroService $heroService;
    public function boot(HeroService $heroService){
        $this->heroService = $heroService;
    }
    public function mount($data){
        $this->data = $data;
        $this->form->setData($data);
        $this->existingFile = $data->image;
        $this->existingFileMobile = $data->mobile_image;
    }
    public function render()
    {
        return view('livewire.backend.admin.banner-management.banner.edit'
        ,[
            'statuses' => HeroStatus::options()
        ]
    );
    }
     public function save()
    {
        $data = $this->form->validate();

        try {
            $data['updated_by'] = admin()->id;


            $this->data = $this->heroService->updateData($this->data->id, $data);

            $this->success(__('Banner updated successfully.'));
            $this->data->fresh();

        } catch (\Exception $e) {

            Log::error('Error updating Banner: ' . $e->getMessage());
            $this->error(__('An error occurred while updating the Banner.'. $e->getMessage()));
        }
    }
        public function resetForm()
    {
         $this->form->reset();
      
        $this->form->setData($this->data);
        $this->existingFile = $this->data->image;
        $this->existingFileMobile = $this->data->mobile_image;
       
    }
}
