<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Product;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ListLayout extends Component
{
    public  $gameSlug ;
    public $categorySlug; 
    public $game ;
    protected $datas;
    public $product;

    

    protected ProductService $productService;
    protected OrderService $orderService;
    public function boot(ProductService $productService, OrderService $orderService){
        $this->productService = $productService;
        $this->orderService = $orderService;
    }
    public function mount($gameSlug, $categorySlug, $game, $datas){
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;
        $this->game = $game;
        $this->datas = $datas;
    }
    public function selectItem($ecnryptedId){

      $this->product = $this->productService->findData(decrypt($ecnryptedId));

      $this->skipRender();
    }

    public function submit(){
      
       
        $token = bin2hex(random_bytes(126));
        $order = $this->orderService->createData([
            'order_id' => generate_order_id_hybrid(),
            'user_id' => user()->id,
            'source_id' => $this->product->id,
            'source_type' => Product::class,
            'total_amount' => ($this->product->price * $this->product->quantity),
            'tax_amount' => 0,
            'grand_total' => ($this->product->price * $this->product->quantity),
        ]);
        Session::driver('database')->put("checkout_{$token}", [
            'order_id' => $order->id,
            'price_locked' => ($this->product->price * $this->product->quantity) ,
            'expires_at' => now()->addMinutes((int) env('ORDER_CHECKOUT_TIMEOUT_MINUTES', 5))->timestamp,
        ]);
        return $this->redirect(
            route('game.checkout', ['slug' => encrypt($this->product->id), 'token' => $token]),
            navigate: true
        );


    }
    public function render()
    {
       

        return view('livewire.frontend.product.list-layout', [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'game' => $this->game,
            'datas' => $this->datas,
           
        ]);
    }


}
