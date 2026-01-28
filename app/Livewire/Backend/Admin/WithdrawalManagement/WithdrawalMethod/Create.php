<?php

namespace App\Livewire\Backend\Admin\WithdrawalManagement\WithdrawalMethod;

use App\Enums\ActiveInactiveEnum;
use App\Enums\WithdrawalFeeType;
use App\Livewire\Forms\Backend\Admin\WithdrawManagement\WithdrawalMethodForm;
use App\Services\WithdrawalMethodService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    public WithdrawalMethodForm $form;

    protected WithdrawalMethodService $service;

    public function boot(WithdrawalMethodService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->form->status = ActiveInactiveEnum::ACTIVE->value;
        $this->form->fee_type = WithdrawalFeeType::FIXED->value;
        $this->form->min_amount = '0';
        $this->form->fee_amount = '0';
        $this->form->fee_percentage = '0';
    }

    public function resetForm()
    {
        $this->form->reset();

        // Reset to default values
        $this->form->status = ActiveInactiveEnum::ACTIVE->value;
        $this->form->fee_type = WithdrawalFeeType::FIXED->value;
        $this->form->min_amount = '0';
        $this->form->fee_amount = '0';
        $this->form->fee_percentage = '0';

        // Dispatch browser event to reset Alpine fields
        $this->dispatch('reset-fields');

        $this->success('Form has been reset.');
    }

    public function save()
    {
        // Validate the form and gather normalized payload (ensures icon + processed fields)
        $this->form->validate();
        $data = $this->form->fillables();

        DB::beginTransaction();

        try {
            $this->service->createData($data);

            DB::commit();

            $this->success('Withdrawal method created successfully.');

            return redirect()->route('admin.wm.method.index');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error
            Log::error('Withdrawal Method Creation Error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            $this->error('Failed to create withdrawal method.'.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.withdrawal-management.withdrawal-method.create', [
            'statuses' => ActiveInactiveEnum::options(),
            'fee_types' => WithdrawalFeeType::options(),
        ]);
    }
}
