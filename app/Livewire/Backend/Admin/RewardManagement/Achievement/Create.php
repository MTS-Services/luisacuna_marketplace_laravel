<?php

namespace App\Livewire\Backend\Admin\RewardManagement\Achievement;

use Livewire\Component;
use App\Services\RankService;
use App\Enums\AchievementStatus;
use App\Services\CategoryService;
use App\Services\AchievementService;
use App\Traits\Livewire\WithNotification;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Livewire\Forms\Backend\Admin\RewardManagement\AchievementForm;


class Create extends Component
{
    use WithNotification, WithFileUploads;
    public AchievementForm $form;

    protected AchievementService $service;
    protected RankService $rank;
    protected CategoryService $category;


    /**
     * Inject the CurrencyService via the boot method.
     */
    public function boot(AchievementService $service, RankService $rank, CategoryService $category)
    {
        $this->service = $service;
        $this->rank = $rank;
        $this->category = $category;
    }


    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = AchievementStatus::ACTIVE->value;
    }
    public function render()
    {
        $ranks = $this->rank->getAllDatas();
        $categories = $this->category->getAllDatas();


        return view('livewire.backend.admin.reward-management.achievement.create', [
            'statuses' => AchievementStatus::options(),
            'ranks' => $ranks,
            'categories' => $categories,
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
            return $this->redirect(route('admin.rm.achievement.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to create data: ' . $e->getMessage());
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
