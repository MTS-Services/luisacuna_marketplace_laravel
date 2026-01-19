<?php

namespace App\Livewire\Backend\User\Offers;

use Livewire\Component;
use App\Models\FeeSettings;
use Livewire\Attributes\Locked;
use App\Services\ProductService;
use App\Services\PlatformService;
use App\Traits\Livewire\WithNotification;

class Edit extends Component
{
    use WithNotification;

    #[Locked]
    public $productId;

    public $offer;

    public $timelineOptions = [];

    public $platforms = [];
    public $platform_id = null;
    public $price = null;
    public $quantity = null;
    public $description = null;
    public $name = null;
    public $delivery_timeline = null;
    public $deliveryMethod = null;
    public $fields = [];

    public $gameConfigs = [];

    protected ProductService $service;
    protected PlatformService $platformService;

    public function boot(ProductService $service, PlatformService $platformService)
    {
        $this->service = $service;
        $this->platformService = $platformService;
    }

    public function mount($encrypted_id)
    {
        $this->productId = decrypt($encrypted_id);
        $this->offer = $this->service->findData($this->productId);

        // Load necessary relationships
        $this->offer->load([
            'game',
            'category',
            'product_configs',
        ]);

        $this->gameConfigs = $this->offer->game->gameconfig->where('category_id', $this->offer->category_id);

        // Set initial data
        $this->setData($this->offer);

        // Initialize timeline options
        $this->updatedDeliveryMethod($this->deliveryMethod);

        // Load platforms
        $this->platforms = $this->platformService->getActiveData();
    }

    public function updatedDeliveryMethod($deliveryMethod)
    {
        if (!$deliveryMethod) {
            return;
        }

        $this->deliveryMethod = $deliveryMethod;
        $this->timelineOptions = delivery_timelines($deliveryMethod);

        // Auto select first option if delivery timeline not set
        if (!$this->delivery_timeline && !empty($this->timelineOptions)) {
            $this->delivery_timeline = array_key_first($this->timelineOptions);
        }
    }

    public function submitOffer()
    {
        $data = $this->validate(
            [
                'platform_id' => 'required|integer|max:255',
                'price' => 'required|numeric|min:1',
                'quantity' => 'required|integer|min:1',
                'description' => 'nullable|string',
                'deliveryMethod' => 'required|string|max:255',
                'delivery_timeline' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'fields' => 'nullable|array',
                'fields.*.value' => 'required',
            ],
            [
                'platform_id.required' => 'Platform is required.',
                'price.required' => 'Price is required.',
                'price.min' => 'Price must be at least 1.',
                'quantity.required' => 'Stock quantity is required.',
                'quantity.min' => 'Quantity must be at least 1.',
                'deliveryMethod.required' => 'Delivery method is required.',
                'name.required' => 'Offer title is required.',
                'delivery_timeline.required' => 'Delivery timeline is required.',
                'fields.*.value.required' => 'This field must be filled.',
            ]
        );

        // Prepare data for update
        $updateData = [
            'platform_id' => $data['platform_id'],
            'price' => $data['price'] * 1,
            'quantity' => $data['quantity'],
            'description' => $data['description'],
            'delivery_method' => $data['deliveryMethod'],
            'delivery_timeline' => $data['delivery_timeline'],
            'name' => $data['name'],
            'fields' => $data['fields'] ?? [],
        ];

        // Update the product
        $updatedProduct = $this->service->updateData($this->productId, $updateData);

        // Update product configs
        if (!empty($data['fields'])) {
            $this->updateProductConfigs($updatedProduct, $data['fields']);
        }

        // Success notification
        $this->toastSuccess('Offer updated successfully');

        // Redirect to the offer listing page
        return redirect(route('user.user-offer.category', $this->offer->category->slug));
    }

    protected function updateProductConfigs($product, $fields)
    {
        // Delete existing product configs for this product
        $product->product_configs()->delete();

        // Create new product configs
        foreach ($fields as $gameConfigId => $fieldData) {
            if (!empty($fieldData['value'])) {
                $product->product_configs()->create([
                    'game_config_id' => $gameConfigId,
                    'category_id' => $product->category_id,
                    'value' => $fieldData['value'],
                    'sort_order' => 0,
                ]);
            }
        }
    }

    public function render()
    {
        $flatFee = FeeSettings::first()->value('buyer_fee');
        return view('livewire.backend.user.offers.edit', [
            'flatFee' => $flatFee
        ]);
    }

    public function setData($data)
    {
        $this->platform_id = $data->platform_id;
        $this->price = $data->price;
        $this->quantity = $data->quantity;
        $this->description = $data->description;
        $this->name = $data->name;
        $this->delivery_timeline = $data->delivery_timeline;
        $this->deliveryMethod = $data->delivery_method;

        // Load existing product_configs into fields array
        if ($data->product_configs && $data->product_configs->isNotEmpty()) {
            foreach ($data->product_configs as $config) {
                $this->fields[$config->game_config_id] = [
                    'value' => $config->value
                ];
            }
        }
    }
}
