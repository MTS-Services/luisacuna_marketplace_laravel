<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Product;
use App\Services\GameService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Traits\WithPaginationData;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ListLayout extends Component
{
    use WithPaginationData;
    public  $gameSlug ;
    public $categorySlug; 
    public $game;
    protected $datas;
    public $product;

   

    protected ProductService $productService;
    protected OrderService $orderService;
    protected GameService $gameService;
    public function boot(ProductService $productService, OrderService $orderService, GameService $gameService){
        $this->productService = $productService;
        $this->orderService = $orderService;
        $this->gameService = $gameService;
    }
    public function mount($gameSlug, $categorySlug ){
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;
        $this->game = $this->gameService->findData($gameSlug, 'slug');

    }
   public function getDatas(){
        
     return  $this->productService->getPaginatedData($this->perPage = 2 , [

            'gameSlug' => $this->gameSlug,

            'categorySlug' => $this->categorySlug,


        ]);
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
        Session::driver('redis')->put("checkout_{$token}", [
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
       
        $this->datas = $this->getDatas();
        $this->pagination = $this->paginationData($this->datas);
        
        return view('livewire.frontend.product.list-layout', [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'game' => $this->game,
            'datas' => $this->datas,
           
        ]);
    }


}
