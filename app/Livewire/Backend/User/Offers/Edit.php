<?php

namespace App\Livewire\Backend\User\Offers;

use App\Services\PlatformService;
use App\Services\ProductService;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Edit extends Component
{

    #[Locked]
    public $encryptedId;

    public $offer;

    public $timelineOptions = [];

    public $platforms = [];
    public $platform_id = null;
    public $price = null;
    public $quantity = null;
    public $description = null;
    public $name = null;
    public $delivery_timeline = null;
    public $deliveryMethod;
    public $fields = [];

 

    protected ProductService $service;
    protected PlatformService $platformService;
    public function boot(ProductService $service, PlatformService $platformService)
    {
        $this->service = $service;
        $this->platformService = $platformService;
    }

    public function mount($encrypted_id) {
        $this->encryptedId = $encrypted_id;
        $this->updatedDeliveryMethod($this->deliveryMethod);
    }


    public function updatedDeliveryMethod($deliveryMethod)
    {
        // Update timeline options based on delivery method
        if ($deliveryMethod == "manual") {
            $this->timelineOptions = delivery_timelines($this->deliveryMethod);
        } else {
            $this->timelineOptions = delivery_timelines($this->deliveryMethod);
        }

        // Reset delivery time when method changes
        $this->delivery_timeline = null;
    }

    public function submitOffer() {
         $data = $this->validate(
            [

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




        dd($data);

        $createdData = $this->productService->createData($data);


        // success

        $this->toastSuccess('Offer created successfully');

        // Reset properties
        $this->resetField();

        return redirect(route('user.user-offer.category', $createdData->category->slug));

        // success

        $this->toastSuccess('Offer created successfully');

        // Reset properties
        $this->resetField();

        return redirect(route('user.user-offer.category', $createdData->category->slug));
    }
    public function render()
    {

        $this->offer = $this->service->findData($this->encryptedId);

        $this->offer->load([
            'game.gameConfig' => function ($query) {
                $query->where('category_id', $this->offer->category_id)->where('game_id', $this->offer->game_id);
            },
            'category',
        ]);
        $this->setData($this->offer);

        $this->platforms = $this->platformService->getActiveData();
        return view('livewire.backend.user.offers.edit');
    }

    public function setData($data){

        $this->platform_id = $data->platform_id;
        $this->price = $data->price;
        $this->quantity = $data->quantity;
        $this->description = $data->description;
        $this->name = $data->name;
        $this->delivery_timeline = $data->delivery_timeline;
        $this->deliveryMethod = $data->delivery_method;
    }
}
