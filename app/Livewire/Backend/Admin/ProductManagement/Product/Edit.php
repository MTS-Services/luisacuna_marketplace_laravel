<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Product;

use App\Models\Product;
use Livewire\Component;
use App\Enums\ProductStatus;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use App\Enums\ProductsVisibility;
use App\Services\Game\GameService;
use App\Services\User\UserService;
use App\Enums\ProductsDeliveryMethod;
use App\Services\Product\ProductService;
use App\Traits\Livewire\WithNotification;
use App\Services\Product\ProductTypeService;
use App\Livewire\Forms\Backend\Admin\ProductManagement\ProducForm;

class Edit extends Component
{
    use WithNotification, WithFileUploads;


    public ProducForm $form;

    #[Locked]
    public Product $product;
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


    public function mount(Product $data): void
    {
        $this->product = $data;
        $this->form->setData($this->product);
    }
    public function render()
    {
        $games = $this->gameService->paginate();
        $PTypes = $this->PTypeService->getAll();
        $users = $this->userService->getAllSellersData('first_name', 'asc');

        return view('livewire.backend.admin.product-management.product.edit', [
            'statuses' => ProductStatus::options(),
            'deliveryMethods' => ProductsDeliveryMethod::options(),
            'visibilitis' => ProductsVisibility::options(),
            'games' => $games,
            'PTypes' => $PTypes,
            'users' => $users

        ]);
    }

    public function save()
    {
        $this->form->validate();
        try {
            $data = $this->form->fillables();
            $data['updater_id'] = admin()->id;
            $data['updater_by'] = admin()->id;
            $updated = $this->service->updateData($this->product->id, $data);

            $this->dispatch('ProductUpdated');
            $this->success('Data updated successfully.');

            return $this->redirect(route('admin.pm.product.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }

    public function resetForm(): void
    {
        $this->form->setData($this->product);
        $this->form->resetValidation();
    }
}
