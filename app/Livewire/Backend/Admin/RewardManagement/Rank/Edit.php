<?php

namespace App\Livewire\Backend\Admin\RewardManagement\Rank;

use App\Models\Rank;
use Livewire\Component;
use App\Enums\RankStatus;
use App\Services\RankService;
use Livewire\Attributes\Locked;
use App\Traits\Livewire\WithNotification;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Livewire\Forms\Backend\Admin\RewardManagement\RankForm;

class Edit extends Component
{

    use WithNotification, WithFileUploads;
    public RankForm $form;


    #[Locked]
    public Rank $data;
    protected RankService $service;

    public function boot(RankService $service)
    {
        $this->service = $service;
    }


    /**
     * Initialize default form values.
     */
    public function mount(Rank $data): void
    {
        $this->data = $data;
        $this->form->setData($data);
    }



    public function render()
    {
        return view('livewire.backend.admin.reward-management.rank.edit', [
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
            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->data->id, $data);

            $this->success('Data updated successfully.');
            return $this->redirect(route('admin.rm.rank.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
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
