<?php

namespace App\Livewire\Backend\Admin\GameManagement\Category;

use Livewire\Component;
use App\Models\Category;
use App\Enums\CategoryStatus;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Backend\Admin\GameManagement\CategoryForm;

class Edit extends Component
{
    use WithNotification, WithFileUploads;

    public $categoryId = null;
    public CategoryForm $form;

    #[Locked]
    public Category $data;
    protected CategoryService $service;


    public function boot(CategoryService $service)
    {
        $this->service = $service;
    }

    public function mount(Category $data)
    {
        $this->data = $data;
        $this->form->setData($data);
    }
    public function render()
    {
        return view('livewire.backend.admin.game-management.category.edit', [
            'statuses'   => CategoryStatus::options(),
        ]);
    }


    /**
     * Handle form submission to update the Category.
     */
    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->data->id, $data);

            $this->success('Data updated successfully.');
            return $this->redirect(route('admin.gm.category.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel editing and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->setData($this->currency);
        $this->form->resetValidation();
    }
}
