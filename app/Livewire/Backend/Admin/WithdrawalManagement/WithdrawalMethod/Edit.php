<?php

namespace App\Livewire\Backend\Admin\WithdrawalManagement\WithdrawalMethod;

use App\Livewire\Forms\Backend\Admin\WithdrawManagement\WithdrawalMethodForm;
use App\Services\WithdrawalMethodService;
use App\Traits\Livewire\WithNotification;
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
    public WithdrawalMethod $data;
    public $dataId;
    public $existingFile;

    protected WithdrawalMethodService $service;

    public function boot(WithdrawalMethodService $service)
    {
        $this->service = $service;
    }

    public function mount(WithdrawalMethod $data): void
    {
        $this->data = $data;
        $this->dataId = $data->id;
        $this->form->setData($data);
        $this->existingFile = $this->data->icon;
    }

    public function update()
    {
        $data = $this->form->validate();

        DB::beginTransaction();

        try {
            $this->service->updateData($this->dataId, $data);

            DB::commit();

            $this->success('Withdrawal method updated successfully.');

            return redirect()->route('admin.wm.method.index');

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Withdrawal Method Update Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            $this->error('Failed to update withdrawal method. ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.withdrawal-management.withdrawal-method.edit', [
            'statuses' => ActiveInactiveEnum::options(),
            'fee_types' => WithdrawalFeeType::options(),
        ]);
    }
}
