<?php

namespace App\Livewire\Backend\User\Offers;

use App\Models\Game;
use App\Models\Platform;
use App\Models\Product;
use Livewire\Component;
use App\Services\GameService;
use App\Services\CategoryService;
use App\Services\PlatformService;
use App\Services\ProductService;
use App\Traits\Livewire\WithNotification;

class Offer extends Component
{

    use WithNotification;
    //Public Variable 

    public $step = 1;

    public $categoryId = null;
    public $categoryName = null;
    public $gameId = null;
    public $deliveryMethod = null;
    public $platform_id = null;
    public $price = null;
    public $quantity = null;
    public $description = null;
    public $name = null;
    public $delivery_timeline = null;
    public $fields = [];


    // Dynamic Variable Just for demostration , if it store in another table then remove this code .
    // Dynamic varibale created by "config_". game_confisg's slug but if slug contains '-' it will replace by "_".

    public $config_server;
    public $config_faction;
    public $config_number_of_skin;
    public $config_rare_skin;

    //Data Collections

    public $games;

    // When A single Game selected will store the data to $game
    public Game $game;


    // Dynamic Configs Data need to create offer
    public $gameConfigs;

    public $platforms;

    public $servers;

    public $deliveryMethods;


    //Load Services

    protected CategoryService $categoryService;
    protected GameService $gameService;
    protected PlatformService $platformService;
    protected ProductService $productService;

    public $timelineOptions = [];


    public function boot(CategoryService $categoryService, GameService $gameService, PlatformService $platformService, ProductService $productService)
    {
        $this->categoryService = $categoryService;
        $this->gameService = $gameService;
        $this->platformService = $platformService;
        $this->productService = $productService;
    }

    public function updatedDeliveryMethod($deliveryMethod)
    {
        // Update timeline options based on delivery method
        if ($deliveryMethod === 'manual') {
            $this->timelineOptions = ['1 Hour', '2 Hours', '3 Hours', '4 Hours']; 
        } else {
            $this->timelineOptions = ["Instant Delivery", '1 Hour', '2 Hours', '3 Hours', '4 Hours'];
        }
        
        // Reset delivery time when method changes
        $this->delivery_timeline = null;
    }

    // When Select Category will run Select Category with category id and name
    public function selectCategory($categoryId, $categoryName)
    {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;


        $category = $this->categoryService->findData($categoryId)->load('games');

        $this->games = $category->games;

        $this->step = 2;
    }

    // When Select Game it will go next with game id

    public function selectGame()
    {
        $this->validate(
            [
                'gameId' => 'required',
            ],
            [
                'gameId.required' => 'Please select a game before continuing.',
            ]
        );

        $this->updatedSelectedGame($this->gameId);

        $this->step = 3;
    }

    // Must call this with game id to create next step

    public function updatedSelectedGame($gameId)
    {


        if ($gameId) {

            $game = $this->gameService->findData($gameId);

            $this->game = $game;

            // Load only the matched configs, not all
            $game->load([
                'gameConfig' => function ($q) {
                    $q->where('category_id', $this->categoryId);
                },
            ]);

            $this->gameConfigs = $game->gameConfig;


            $this->platforms = $this->platformService->getActiveData();



            // $this->deliveryMethods = json_decode($game->gameConfig->first()->delivery_methods, true);

        } else {
            return;
        }
    }



    public function submitOffer()
    {
        // For Test
        // $arr = [
        //     'game_id' => $this->gameId,
        //     'category_id' => $this->categoryId,
        //     'delivery_method' => $this->deliveryMethod,
        //     'platform'=> $this->platform,
        //     'price' => $this->price,
        //     'stock_quantity' => $this->stock_quantity,
        //     'description' => $this->description,
        //     'config_server' => $this->config_server,
        //     'config_faction' => $this->config_faction,
        //     'config_number_of_skin' => $this->config_number_of_skin,
        //     'config_rare_skin' => $this->config_rare_skin

        // ];

        $data = $this->validate(
            [
                'gameId' => 'required|integer',
                'categoryId' => 'required|integer',
                'platform_id' => 'required|integer|max:255',
                'price' => 'required|numeric|min:1',
                'quantity' => 'required|integer|min:1',
                'description' => 'nullable',
                'deliveryMethod' => 'required|string|max:255',
                'delivery_timeline' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'fields' => 'nullable|array',
                'fields.*.value' => 'required',

            ],
            [
                'gameId.required' => 'Please select a game.',
                'categoryId.required' => 'Category is required.',
                'platform_id.required' => 'Platform is required.',
                'price.required' => 'Price is required.',
                'quantity.required' => 'Stock quantity is required.',
                'deliveryMethod.required' => 'Delivery method is required.',
                'name.required' => 'Name is required.',
                'delivery_timeline' => "Delivery Timeline is required.",
                'fields.*.required' => 'This Field must to be filled.',
            ]

        );
        $data['user_id'] = user()->id;
        
        if ($data['gameId']) {
            $data['game_id'] = $data['gameId'];
            unset($data['gameId']);
        }

        if ($data['categoryId']) {
            $data['category_id'] = $data['categoryId'];
            unset($data['categoryId']);
        }

        if ($data['price']) {
            $data['price'] = $data['price'] * 1;
        }



        $createdData = $this->productService->createData($data);

      
       // success

       $this->toastSuccess('Offer created successfully');

        // Reset properties
        $this->resetField();

        return redirect(route('user.user-offer.category', $createdData->category->slug));
    }


    public function render()
    {
        $categories = $this->categoryService->getDatas();

        return view('livewire.backend.user.offers.offer', [
            'categories' => $categories
        ]);
    }

    // Existing



    public function back()
    {
        if ($this->step > 1) {
            $this->step--;
        }
        $this->resetField();
    }

    public function resetField()
    {

        $this->gameId = null;
        $this->categoryId = null;
        $this->deliveryMethod = null;
        // $this->platform = null;
        $this->price = null;
        $this->quantity = null;
        $this->description = null;
        $this->name = null;

    }

    public function serachFilter() {}
}
