<frontend::app>
    <div class="container my-10">
        <div class="grid grid-cols-3 gap-4">
            @foreach ($items as $item)
                <div class="card bg-base-200 w-full">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">{{ $item->price }}</p>
                        <button wire:click="buyNow('{{ encrypt($item->slug) }}')" class="btn btn-primary">Buy Now</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</frontend::app>
