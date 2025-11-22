<?php

namespace App\Livewire\Backend\Admin\RewardManagement\Rank;

use Livewire\Component;
use App\Enums\RankStatus;
use App\Services\RankService;
use App\Traits\Livewire\WithNotification;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Livewire\Forms\RankForm;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithNotification, WithFileUploads;
    public RankForm $form;



    protected RankService $service;

    /**
     * Inject the CurrencyService via the boot method.
     */

    public function boot(RankService $service)
    {
        $this->service = $service;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = RankStatus::ACTIVE->value;
    }




    public function render()
    {
        return view('livewire.backend.admin.reward-management.rank.create', [
            'statuses' => RankStatus::options(),
        ]);
    }


    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {
        $data = $this->form->validate();

        try {

            $data['created_by'] = admin()->id;

            $this->service->createData($data);

            $this->success('Data created successfully.');

            return $this->redirect(route('admin.rm.rank.index'), navigate: true);
        } catch (\Exception $e) {

            Log::error("Failed to create Rank data", [
                'error' => $e->getMessage(),
            ]);
            $this->error('Failed to create data ');
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->reset();
    }
}
