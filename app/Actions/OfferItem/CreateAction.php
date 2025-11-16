<?php

namespace App\Actions\OfferItem;

use App\Models\OfferItem;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\OfferItemRepositoryInterface;

class CreateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected OfferItemRepositoryInterface $interface
    ) {}


    public function execute(array $data): OfferItem
    {
        return DB::transaction(function () use ($data) {
            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }
}
