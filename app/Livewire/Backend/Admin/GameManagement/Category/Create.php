<?php

namespace App\Livewire\Backend\Admin\GameManagement\Category;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Enums\CategoryStatus;
use App\Enums\CategoryLayout;
use Illuminate\Support\Facades\Log;
use App\Services\CategoryService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Backend\Admin\GameManagement\CategoryForm;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    protected CategoryService $service;

    public CategoryForm $form;

    public function boot(CategoryService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->form->status = CategoryStatus::ACTIVE->value;
        $this->form->layout = CategoryLayout::LIST_GRID->value;
    }
    public function render()
    {

        return view('livewire.backend.admin.game-management.category.create', [
            'statuses'   => CategoryStatus::options(),
            'layouts'   => CategoryLayout::options(),
        ]);
    }


    /**
     * Handle form submission to create a new Category.
     */
    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['created_by'] = admin()->id;
            $this->service->createData($data);
            $this->success(
                'Category created successfully! ' .
                    'Translations are being processed in the background.'
            );
            return $this->redirect(route('admin.gm.category.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to create data: ' . $e->getMessage());
        }
    }
    public function resetFrom()
    {
        $this->form->reset();
        $this->dispatch('file-input-reset');
    }
}
