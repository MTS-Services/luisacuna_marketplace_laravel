<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Product;

use Livewire\Component;
use App\Enums\ProductsStatus;
use Livewire\WithFileUploads;
use App\Enums\ProductsVisibility;
use App\Services\Game\GameService;
use App\Services\User\UserService;
use App\Enums\ProductsDeliveryMethod;
use App\Services\Product\ProductService;
use App\Traits\Livewire\WithNotification;
use App\Services\Product\ProductTypeService;
use App\Livewire\Forms\Backend\Admin\ProductManagement\ProducForm;
use App\Models\Admin;

class Create extends Component
{

    use WithNotification, WithFileUploads;

    public ProducForm $form;

    protected ProductService $service;
    protected GameService $gameService;
    protected ProductTypeService $PTypeService;
    protected UserService $userService;

    public function boot(ProductService $service, GameService $gameService, ProductTypeService $PTypeService, UserService $userService)
    {
        $this->service = $service;
        $this->gameService = $gameService;
        $this->PTypeService = $PTypeService;
        $this->userService = $userService;
    }

    public function mount(): void
    {
        // $this->form->status = ProductsStatus::ACTIVE->value;
    }
    public function render()
    {
        $games = $this->gameService->paginate();
        $PTypes = $this->PTypeService->getAll();
        $users = $this->userService->getAllSellersData('first_name', 'asc');

        return view('livewire.backend.admin.product-management.product.create', [
            'statuses' => ProductsStatus::options(),
            'deliveryMethods' => ProductsDeliveryMethod::options(),
            'visibilitis' => ProductsVisibility::options(),
            'games' => $games,
            'PTypes' => $PTypes,
            'users' => $users
        ]);
    }

    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {
        $this->form->validate();
        dd($this->form->fillables());
        try {
            $data = $this->form->fillables();
            $data['creater_id'] = admin()->id;
            $data['creater_type'] = Admin::class;
            $this->service->createData($data);

            $this->success('Data created successfully.');

            return $this->redirect(route('admin.pm.product.index'), navigate: true);
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
