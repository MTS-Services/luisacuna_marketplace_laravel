<?php

namespace App\Livewire\Frontend\Product;

use App\Services\GameService;
use App\Services\PlatformService;
use App\Services\ProductService;
use App\Traits\WithPaginationData;
use Livewire\Attributes\Url;
use Livewire\Component;

class GridLayout extends Component
{
    use WithPaginationData;

    public $game;

    public $platforms;

    public $categorySlug;

    public $gameSlug;

    public $delivery_timelines;

    protected $datas;

    // This Serach
    #[Url('q')]
    public $search = '';


    public $platform_id = '';

    #[Url()]
    public $delivery_timeline = '';

    public $category_id = 0;
    #[Url()]
    public $min_price = 0;
    #[Url()]
    public $max_price = 0;
    
    #[Url('filter')]
    public $filter_by_tag = '';

    #[Url(as: 'sort')]
    public $sortDirection = 'desc';

    public $tags = [];

    protected PlatformService $platformService;
    protected ProductService $productService;
    protected GameService $gameService;

    public function boot(PlatformService $platformService, ProductService $productService, GameService $gameService)
    {

        $this->platformService = $platformService;

        $this->productService = $productService;

        $this->gameService = $gameService;
    }
    public function mount($gameSlug, $categorySlug)
    {

        $this->gameSlug = $gameSlug;

        $this->categorySlug = $categorySlug;

        $this->game = $this->gameService->findData($gameSlug, 'slug')->load(['gameConfig', 'tags']);


        $this->delivery_timelines = [
            [
                'label' => 'Instant Delivery',
                'value' => 'Instant Delivery',
            ],
            [
                'label' => '1 Hour',
                'value' => '1 Hour',
            ],
            [
                'label' => '2 Hour',
                'value' => '2 Hour',
            ],
            [
                'label' => '3 Hour',
                'value' => '3 Hour',
            ],
            [
                'label' => '4 Hour',
                'value' => '4 Hour',
            ],


        ];


        $this->platforms = $this->platformService->getAllDatas('name', 'asc') ?? [];


        // Formatting Tags
        $tags = $this->game->tags->pluck('name')->toArray();
        $gameConfigs = $this->game->gameConfig->pluck('dropdown_values')->toArray();
        $array = collect($gameConfigs)->filter(fn($value) => !is_null($value))->values()->toArray();
        $platforms = $this->platforms->pluck('name')->toArray();
        $shuffledTags = collect(array_merge($tags, $platforms, array_merge(...$array)))->shuffle()->values()->toArray();

        $this->tags = $shuffledTags;
    }



    public function render()
    {


        $this->datas = $this->productService->getPaginatedData($this->perPage, [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'skipSelf' => true,
            'search' => $this->search,
            'platform_id' => $this->platform_id,
            'delivery_timeline' => $this->delivery_timeline,
            'category_id' => $this->category_id,
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
            'filter_by_tag' => $this->filter_by_tag,
            'sort_direction' => $this->sortDirection,
        ]);
        $this->datas->load('user');

        $this->paginationData($this->datas);

        return view('livewire.frontend.product.grid-layout', [
            'datas' => $this->datas
        ]);
    }

    public function resetAllFilters()
    {

        $this->reset([
            'search',
            'platform_id',
            'delivery_timeline',
            'category_id',
            'min_price',
            'max_price',
            'filter_by_tag'
        ]);
    }

    public function restPrice()
    {
        $this->min_price = 0;
        $this->max_price = 0;
    }
}
