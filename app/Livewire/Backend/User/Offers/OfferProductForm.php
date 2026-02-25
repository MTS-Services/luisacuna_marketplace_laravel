<?php

namespace App\Livewire\Backend\User\Offers;

use App\Models\Category;
use App\Models\FeeSettings;
use App\Models\Game;
use App\Models\GameConfig;
use App\Services\PlatformService;
use App\Services\ProductService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class OfferProductForm extends Component
{
    use WithNotification;

    #[Locked]
    public string $categorySlug;

    #[Locked]
    public string $gameSlug;

    #[Locked]
    public int $categoryId;

    #[Locked]
    public int $gameId;

    #[Locked]
    public string $categoryName;

    #[Locked]
    public string $gameName;

    #[Locked]
    public ?string $gameLogo = null;

    public ?string $name = null;

    public ?string $description = null;

    public ?string $deliveryMethod = null;

    public ?string $delivery_timeline = null;

    public ?int $platform_id = null;

    public ?float $price = null;

    public ?int $quantity = null;

    public array $fields = [];

    public array $timelineOptions = [];

    /**
     * Delivery methods available for this game+category.
     *
     * @var string[]
     */
    #[Locked]
    public array $availableDeliveryMethods = [];

    /**
     * Whether delivery section should be shown.
     */
    #[Locked]
    public bool $hasDelivery = false;

    protected ProductService $productService;

    protected PlatformService $platformService;

    public function boot(ProductService $productService, PlatformService $platformService): void
    {
        $this->productService = $productService;
        $this->platformService = $platformService;
    }

    public function mount(string $categorySlug, string $gameSlug): void
    {
        $this->categorySlug = $categorySlug;
        $this->gameSlug = $gameSlug;

        $category = Category::where('slug', $categorySlug)->active()->firstOrFail();
        $game = Game::where('slug', $gameSlug)
            ->whereHas('categories', fn ($q) => $q->where('categories.id', $category->id))
            ->firstOrFail();

        $this->categoryId = $category->id;
        $this->gameId = $game->id;
        $this->categoryName = $category->name;
        $this->gameName = $game->name;
        $this->gameLogo = $game->logo;

        $this->loadDeliveryOptions();
        $this->initializeFields();
    }

    protected function loadDeliveryOptions(): void
    {
        $deliveryConfig = GameConfig::forGame($this->gameId)
            ->forCategory($this->categoryId)
            ->deliveryMethodsOnly()
            ->first();

        $methods = $deliveryConfig?->delivery_methods ?? [];

        if (! empty($methods)) {
            $this->hasDelivery = true;

            $ordered = [];
            if (in_array('instant', $methods)) {
                $ordered[] = 'instant';
            }

            foreach ($methods as $m) {
                if ($m !== 'instant' && ! in_array($m, $ordered)) {
                    $ordered[] = $m;
                }
            }
            $this->availableDeliveryMethods = $ordered;

            if (count($ordered) === 1 && $ordered[0] === 'instant') {
                $this->deliveryMethod = 'instant';
                $this->timelineOptions = delivery_timelines('instant');
                $this->delivery_timeline = 'instant';
            }
        }
    }

    public function updatedDeliveryMethod(?string $value): void
    {
        if (! $value) {
            $this->timelineOptions = [];
            $this->delivery_timeline = null;

            return;
        }

        $this->timelineOptions = delivery_timelines($value);

        if ($value === 'instant') {
            $this->delivery_timeline = 'instant';
        } else {
            $this->delivery_timeline = array_key_first($this->timelineOptions);
        }
    }

    protected function initializeFields(): void
    {
        $configs = GameConfig::forGame($this->gameId)
            ->forCategory($this->categoryId)
            ->fieldsOnly()
            ->ordered()
            ->get();

        // If no configs, fields stays as empty array []
        foreach ($configs as $config) {
            $this->fields[$config->id] = ['value' => null];
        }
    }

    public function submitOffer(): mixed
    {
        $rules = [
            'name' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'platform_id' => 'required|integer',
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
        ];

        // ✅ Only add fields rules if there are actual configs
        if (! empty($this->fields)) {
            $rules['fields'] = 'array';
            $rules['fields.*.value'] = 'required';
        } else {
            $rules['fields'] = 'nullable|array';
        }

        $messages = [
            'name.required' => __('Offer title is required.'),
            'platform_id.required' => __('Platform is required.'),
            'price.required' => __('Price is required.'),
            'quantity.required' => __('Stock quantity is required.'),
            'fields.*.value.required' => __('This field must be required.'),
        ];

        if ($this->hasDelivery) {
            $rules['deliveryMethod'] = 'required|string|max:255';
            $rules['delivery_timeline'] = 'required|string|max:255';
            $messages['deliveryMethod.required'] = __('Delivery method is required.');
            $messages['delivery_timeline.required'] = __('Delivery timeline is required.');
        }

        $data = $this->validate($rules, $messages);

        $data['user_id'] = user()->id;
        $data['game_id'] = $this->gameId;
        $data['category_id'] = $this->categoryId;

        if (isset($data['price'])) {
            $data['price'] = $data['price'] * 1;
        }

        if (! $this->hasDelivery) {
            $data['deliveryMethod'] = null;
            $data['delivery_timeline'] = null;
        }

        $createdProduct = $this->productService->createData($data);

        $this->toastSuccess(__('Offer created successfully'));

        $categorySlug = $createdProduct->category?->slug;
        $redirectRoute = $categorySlug
            ? route('user.user-offer.category', $categorySlug)
            : route('user.offers');

        return $this->redirect($redirectRoute, navigate: false);
    }

    public function render(): View
    {
        $gameConfigs = GameConfig::forGame($this->gameId)
            ->forCategory($this->categoryId)
            ->fieldsOnly()
            ->ordered()
            ->get();

        $platforms = $this->platformService->getActiveData();
        $flatFee = FeeSettings::first()?->value('buyer_fee') ?? 0;

        return view('livewire.backend.user.offers.offer-product-form', [
            'gameConfigs' => $gameConfigs,
            'platforms' => $platforms,
            'flatFee' => $flatFee,
        ]);
    }
}
