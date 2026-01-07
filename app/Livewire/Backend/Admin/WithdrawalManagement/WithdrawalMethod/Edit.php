<?php

namespace App\Livewire\Backend\Admin\WithdrawalManagement\WithdrawalMethod;

use App\Livewire\Forms\Backend\Admin\WithdrawManagement\WithdrawalMethodForm;
use App\Services\WithdrawalMethodService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Enums\ActiveInactiveEnum;
use App\Enums\WithdrawalFeeType;
use App\Models\WithdrawalMethod;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    use WithFileUploads, WithNotification;

    public WithdrawalMethodForm $form;
    protected WithdrawalMethodService $service;

    public WithdrawalMethod $data;
    public $dataId;
    public $existingFile;

    public function boot(WithdrawalMethodService $service)
    {
        $this->service = $service;
    }

    public function mount(WithdrawalMethod $data)
    {
        $this->data = $data;
        $this->dataId = $data->id;

        $this->form->setData($data);
        $this->existingFile = $this->data->icon;
    }




    public function render()
    {
        return view('livewire.backend.admin.withdrawal-management.withdrawal-method.edit', [
            'statuses' => ActiveInactiveEnum::options(),
            'fee_types' => WithdrawalFeeType::options(),
        ]);
    }

    public function save()
    {
        $data = $this->form->validate();


        try {
            $data['updater_id'] = admin()->id;
            $this->service->updateData($this->data->id, $data);
            Log::info('Data updated successfully', ['data_id' => $this->data->id]);
            $this->success('Data updated successfully');
            return redirect()->route('admin.wm.withdrawal.index');

        } catch (\Exception $e) {
            Log::error('Failed to update User', [
                'user_id' => $this->dataId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update User: ' . $e->getMessage());
        }
    }

    public function cancel(): void
    {
        $this->redirect(route('admin.wm.withdrawal.index'), navigate: true);
    }

    public function resetForm()
    {
        $this->form->reset();
        $this->form->setData($this->data);

        $this->showReasonField = false;
        $this->existingFile = $this->data->icon;
        $this->dispatch('file-input-reset');
    }
}
