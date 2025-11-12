<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Product;

use Livewire\Component;
use App\Enums\ProductStatus;
use Livewire\WithFileUploads;
use App\Enums\ProductsVisibility;
use App\Services\GameService;
use App\Services\UserService;
use App\Enums\ProductsDeliveryMethod;
use App\Services\ProductService;
use App\Traits\Livewire\WithNotification;
use App\Services\ProductTypeService;
use App\Livewire\Forms\Backend\Admin\ProductManagement\ProducForm;
use App\Models\Admin;
use App\Services\CurrencyService;

class Create extends Component
{

    use WithNotification, WithFileUploads;

    public ProducForm $form;

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

    public function mount(): void
    {
        // $this->form->status = ProductStatus::ACTIVE->value;
    }
    public function render()
    {
        $games = $this->gameService->getPaginatedData();
        $PTypes = $this->PTypeService->getAllDatas();
        $users = $this->userService->getAllSellersData('first_name', 'asc');
        $currencies = $this->currencyService->getAllDatas();

        return view('livewire.backend.admin.product-management.product.create', [
            'statuses' => ProductStatus::options(),
            'deliveryMethods' => ProductsDeliveryMethod::options(),
            'visibilitis' => ProductsVisibility::options(),
            'games' => $games,
            'PTypes' => $PTypes,
            'users' => $users,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {

        $data = $this->form->validate();

        try {
            $data['creater_id'] = admin()->id;
            $data['creater_type'] = get_class(admin());

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
