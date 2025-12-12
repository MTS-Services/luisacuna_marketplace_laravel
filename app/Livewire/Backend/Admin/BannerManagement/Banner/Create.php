<?php

namespace App\Livewire\Backend\Admin\BannerManagement\Banner;

use App\Enums\HeroStatus;
use App\Livewire\Forms\BannerForm;
use App\Services\HeroService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{

    use WithFileUploads , WithNotification;
    public BannerForm $form;
    protected HeroService $heroService;
    public function boot(HeroService $heroService){
        $this->heroService = $heroService;
    }
    public function render()
    {
        return view('livewire.backend.admin.banner-management.banner.create',
        [
            'statuses' => HeroStatus::options()
        ]    
    );
    }
     public function save()
    {
        $data = $this->form->validate();
        unset($data['remove_file'] ,$data['remove_file_mobile']);
        try {
            $data['created_by'] = admin()->id;

         
            $this->heroService->createData($data);

            $this->success(__('Banner created successfully.'));

            return $this->redirect(route('admin.bm.banner.index'), navigate: true);

        } catch (\Exception $e) {

            Log::error('Error updating Banner: ' . $e->getMessage());
            $this->error(__('An error occurred while create the Banner'));
        }
    }
        public function resetForm()
    {
         $this->form->reset();
       
    }

}
