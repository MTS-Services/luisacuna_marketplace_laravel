<?php

namespace App\Livewire\Backend\User\Profile\ShopCategories;

use App\Models\User;
use App\Services\CategoryService;
use App\Services\ProductService;
use Livewire\Attributes\Url;
use Livewire\Component;

class Shop extends Component
{

    #[Url(keep: true)]
    public $activeTab = 'currency';
    public $user;

    public $categories = [];

    protected CategoryService $service ;
    
    public function boot(CategoryService $Service,)
    {
        $this->service = $Service;

    }
    public function mount(User $user)
    {

        $this->user = $user;

        $this->categories = $this->service->getDatas();
        // $this->categories->load('products');

    }
    public function render()
    {
        return view('livewire.backend.user.profile.shop-categories.shop');
    }


}
