<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Product;

use App\Models\Product;
use Livewire\Component;
use App\Enums\ProductStatus;
use App\Services\GameService;
use App\Services\UserService;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use App\Services\ProductService;
use App\Enums\ProductsVisibility;
use App\Services\CurrencyService;
use App\Services\ProductTypeService;
use App\Enums\ProductsDeliveryMethod;
use App\Traits\Livewire\WithNotification;
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
    protected CurrencyService $currencyService;


    public function boot(ProductService $service, GameService $gameService, ProductTypeService $PTypeService, UserService $userService, CurrencyService $currencyService)
    {
        $this->service = $service;
        $this->gameService = $gameService;
        $this->PTypeService = $PTypeService;
        $this->userService = $userService;
        $this->currencyService = $currencyService;
    }


    public function mount(Product $data): void
    {
        $this->product = $data;
        $this->form->setData($this->product);
    }
    public function render()
    {
        $games = $this->gameService->getPaginateDatas();
        $PTypes = $this->PTypeService->getAllDatas();
        $users = $this->userService->getAllSellersData('first_name', 'asc');
        $currencies = $this->currencyService->getAllDatas();




        return view('livewire.backend.admin.product-management.product.edit', [
            'statuses' => ProductStatus::options(),
            'deliveryMethods' => ProductsDeliveryMethod::options(),
            'visibilitis' => ProductsVisibility::options(),
            'games' => $games,
            'PTypes' => $PTypes,
            'users' => $users,
            'currencies' => $currencies,
        ]);
    }

    public function save()
    {
        $data = $this->form->validate();
        try {

            $data['updater_id'] = admin()->id;
            $data['updater_type'] = get_class(admin());

            $updated = $this->service->updateData($this->product->id, $data);

            $this->dispatch('dataUpdated');
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
