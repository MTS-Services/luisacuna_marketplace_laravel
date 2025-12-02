<?php

namespace App\Livewire\Backend\Admin\BannerManagement\Banner;

use App\Enums\HeroStatus;
use App\Livewire\Forms\BannerForm;
use App\Models\Hero;
use App\Services\HeroService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
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

        $this->existingFile = $data->image;

        $this->form->setData($data);
        return view('livewire.backend.admin.banner-management.banner.index', [
            'statuses' => HeroStatus::options(),
        ]);
    }
    public function save()
    {
        $data = $this->form->validate();

        try {
            $data['updated_by'] = admin()->id;


            $this->data = $this->heroService->updateData($this->data->id, $data);

            $this->success(__('Banner updated successfully.'));

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
       
    }
}
